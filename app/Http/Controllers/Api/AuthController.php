<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\forgotRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    // Constructor
    protected $userRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    // Register
    public function register(RegistrationRequest $request)
    {
        $user = $this->userRepo->create($request);

        if (!empty($user)) {

            return [
                'success' => true,
                'user' => $user,
                'msg' => 'user Register successfull'
            ];
        } else {

            return [
                'success' => false,
                'msg' => 'user not Register'
            ];
        }
    }

    // Login
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'token' => $token,
            'user' => $user,
        ]);
    }

    // Change Password
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'min:8'],
        ]);

        $user = $request->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json(['message' => 'Current password is incorrect.'], 422);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return response()->json(['message' => 'Password changed successfully.']);
    }

    // Current User
    public function currentUser(Request $request)
    {

        return response()->json($request->user());
        // return response()->json(User::find(2));
    }

    public function forgotPassword(forgotRequest $request)
    {

        $user = User::where("email", $request->email)->first();

        if (empty($user)) {

            return "Email is not found";
        } else {

            $user->password = $request->password;
            $user->save();
        }

        return ['message' => 'Forgot password successfully.'];
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }
}
