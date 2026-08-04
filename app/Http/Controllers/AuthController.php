<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $users;

    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
        $this->middleware('auth:api', ['except' => ['login','register','forgotPassword','showLoginForm','showRegisterForm','showForgotForm']]);
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

    // API: Register
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = $this->users->create(array_merge($data, ['is_active' => true, 'status' => 'new']));
        $token = JWTAuth::fromUser($user);

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    // API: Login
    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = auth('api')->user();
        if (! $user->is_active) {
            return response()->json(['error' => 'Account deactivated'], 403);
        }

        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Logged out']);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));
        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 400);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = auth('api')->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Current password does not match'], 422);
        }

        $this->users->update($user, ['password' => $request->password]);

        return response()->json(['message' => 'Password updated']);
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        $data = $request->only('name','email');
        $this->users->update($user, $data);
        return response()->json($user->fresh());
    }

    // Administrative actions
    public function assignRole(Request $request, $id)
    {
        $request->validate(['role' => 'required|string']);
        $user = $this->users->findById($id);
        if (! $user) return response()->json(['error'=>'Not found'],404);
        $user->assignRole($request->role);
        return response()->json($user->roles);
    }

    public function revokeRole(Request $request, $id)
    {
        $request->validate(['role' => 'required|string']);
        $user = $this->users->findById($id);
        if (! $user) return response()->json(['error'=>'Not found'],404);
        $user->removeRole($request->role);
        return response()->json($user->roles);
    }

    public function activate(Request $request, $id)
    {
        $user = $this->users->findById($id);
        if (! $user) return response()->json(['error'=>'Not found'],404);
        $this->users->update($user, ['is_active' => true]);
        return response()->json(['message'=>'Activated']);
    }

    public function deactivate(Request $request, $id)
    {
        $user = $this->users->findById($id);
        if (! $user) return response()->json(['error'=>'Not found'],404);
        $this->users->update($user, ['is_active' => false]);
        return response()->json(['message'=>'Deactivated']);
    }

    public function statuses()
    {
        return response()->json($this->users->allStatuses());
    }
}
