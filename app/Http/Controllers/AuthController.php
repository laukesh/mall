<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller implements HasMiddleware
{
    /**
     * User Repository
     */
    protected UserRepositoryInterface $users;

    /**
     * Constructor
     */
    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

    /**
     * Controller Middleware (Laravel 12)
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: [
                'login',
                'register',
                'forgotPassword',
                'showLoginForm',
                'showRegisterForm',
                'showForgotForm',
            ]),
        ];
    }

    /**
     * Display Login Page
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Display Register Page
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Display Forgot Password Page
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Register User
     */
    public function register(Request $request)
    {
      //  dd($request->all());
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        $user = $this->users->create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => $validated['password'],
            'is_active' => true,
            'status'    => 'new',
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful.',
            'token'   => $token,
            'user'    => $user,
        ], 201);
    }

    /**
     * Login User
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 401);
        }

        $user = auth('api')->user();

        if (! $user->is_active) {
            auth('api')->logout();

            return response()->json([
                'success' => false,
                'message' => 'Your account has been deactivated.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    /**
     * Logged In User
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Logout User
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.',
        ]);
    }

    /**
     * Forgot Password
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json([
                'success' => true,
                'message' => __($status),
            ])
            : response()->json([
                'success' => false,
                'message' => __($status),
            ], 400);
    }

    /**
     * Change Password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = auth('api')->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.',
            ], 422);
        }

        $this->users->update($user, [
            'password' => $request->password,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.',
        ]);
    }

    /**
     * Update Profile
     */
    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
        ]);

        $this->users->update($user, $data);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'user' => $user->fresh(),
        ]);
    }

    /**
     * Assign Role
     */
    public function assignRole(Request $request, int $id)
    {
        $request->validate([
            'role' => 'required|string',
        ]);

        $user = $this->users->findById($id);

        if (! $user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->assignRole($request->role);

        return response()->json([
            'success' => true,
            'roles' => $user->getRoleNames(),
        ]);
    }

    /**
     * Revoke Role
     */
    public function revokeRole(Request $request, int $id)
    {
        $request->validate([
            'role' => 'required|string',
        ]);

        $user = $this->users->findById($id);

        if (! $user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->removeRole($request->role);

        return response()->json([
            'success' => true,
            'roles' => $user->getRoleNames(),
        ]);
    }

    /**
     * Activate User
     */
    public function activate(int $id)
    {
        $user = $this->users->findById($id);

        if (! $user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $this->users->update($user, [
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User activated successfully.',
        ]);
    }

    /**
     * Deactivate User
     */
    public function deactivate(int $id)
    {
        $user = $this->users->findById($id);

        if (! $user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $this->users->update($user, [
            'is_active' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User deactivated successfully.',
        ]);
    }

    /**
     * Get Available Statuses
     */
    public function statuses()
    {
        return response()->json([
            'success' => true,
            'statuses' => $this->users->allStatuses(),
        ]);
    }
}