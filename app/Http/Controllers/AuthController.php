<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthController extends Controller
{
    protected $users;

    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
        $this->middleware('guest')->except(['logout','profileForm','updateProfile','changePassword','assignRole','revokeRole','activate','deactivate','statuses']);
        $this->middleware('auth')->only(['logout','profileForm','updateProfile','changePassword','assignRole','revokeRole','activate','deactivate','statuses']);
    }

    // Web views
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function profileForm()
    {
        return view('auth.profile');
    }

    // Web: Register
   public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = $this->users->create(array_merge($data, [
            'is_active' => true,
            'status' => 'new',
            'is_super_admin' => false,
        ]));
          // Give every new user a basic role
        $user->assignRole('User');

        auth()->login($user);

        return redirect()->route('auth.dashboard')
            ->with('success', 'Registration successful.');
    }

    // Web: Login
    public function login11(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials, $request->filled('remember'))) {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput($request->only('email'));
        }

        $user = Auth::user();
        if (! $user->is_active) {
            Auth::logout();
            return back()->withErrors(['email' => 'Account deactivated']);
        }

        $request->session()->regenerate();

        return redirect()->intended('/admin/dashboard/')->with('success', 'Logged in');
    }
    // Web: Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials, $request->filled('remember'))) {
            return back()
                ->withErrors([
                    'email' => 'Invalid credentials'
                ])
                ->withInput($request->only('email'));
        }

        $user = Auth::user();

        // Check active account
        if (!$user->is_active) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Account deactivated'
            ]);
        }

        // Regenerate session
        $request->session()->regenerate();

        // Admin redirect
        if ($user->is_active && $user->status == 'active') {
            return redirect()
                ->intended(route('admin.dashboard'))
                ->with('success', 'Welcome Admin!');
        }

        // Normal user redirect
        return redirect()
            ->intended(route('auth.profile.show'))
            ->with('success', 'Logged in successfully');
    }

   public function logout() {
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login.form')
            ->with('success', 'Logged out successfully.');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }
        return back()->withErrors(['email' => __($status)]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match']);
        }

        $this->users->update($user, ['password' => $request->password]);

        return back()->with('success', 'Password updated');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        $this->users->update($user, $data);
        return back()->with('success', 'Profile updated');
    }

    // Administrative actions - protected by gate 'manage-users'
    public function assignRole(Request $request, $id)
    {
        if (! Gate::allows('manage-users')) {
            abort(403);
        }

        $request->validate(['role' => 'required|string']);
        $user = $this->users->findById($id);
        if (! $user) return redirect()->back()->withErrors(['user' => 'Not found']);
        $user->assignRole($request->role);
        return redirect()->back()->with('success', 'Role assigned');
    }

    public function revokeRole(Request $request, $id)
    {
        if (! Gate::allows('manage-users')) {
            abort(403);
        }

        $request->validate(['role' => 'required|string']);
        $user = $this->users->findById($id);
        if (! $user) return redirect()->back()->withErrors(['user' => 'Not found']);
        $user->removeRole($request->role);
        return redirect()->back()->with('success', 'Role revoked');
    }

    public function activate(Request $request, $id)
    {
        if (! Gate::allows('manage-users')) {
            abort(403);
        }

        $user = $this->users->findById($id);
        if (! $user) return redirect()->back()->withErrors(['user' => 'Not found']);
        $this->users->update($user, ['is_active' => true, 'updated_by' => Auth::id()]);
        return redirect()->back()->with('success', 'Activated');
    }

    public function deactivate(Request $request, $id)
    {
        if (! Gate::allows('manage-users')) {
            abort(403);
        }

        $user = $this->users->findById($id);
        if (! $user) return redirect()->back()->withErrors(['user' => 'Not found']);
        $this->users->update($user, ['is_active' => false, 'updated_by' => Auth::id()]);
        return redirect()->back()->with('success', 'Deactivated');
    }

    public function statuses()
    {
        if (! Gate::allows('manage-users')) {
            abort(403);
        }

        $statuses = $this->users->allStatuses();
        return view('users.statuses', compact('statuses'));
    }
}
