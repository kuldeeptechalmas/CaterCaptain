<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\forgotRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\RawMaterial;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    // Constructor
    protected $userRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    // Dashboard
    public function dashboard(Request $request)
    {
        $raw_material_request = DB::table('material_requests')
            ->where('status', 'pending')
            ->count();
        $raw_material_pending = DB::table('raw_materials')
            ->whereColumn('qty', '<=', 'min_qty')
            ->count();
        $notifications_low_stock = DB::table('notifications')
            ->where('type', 'low_stock')
            ->where('user_id', $request->user()->id)
            ->count();
        $material_request = DB::table('material_requests')->get();

        if ($request->user()->hasRole('superadmin')) {
            return response()->json(
                [
                    'message' => 'Welcome to the dashboard, Superadmin!',
                    'raw_material_request' => $raw_material_request,
                    'raw_material_pending' => $raw_material_pending,
                    'notifications_low_stock' => $notifications_low_stock,
                    'material_request' => $material_request
                ]
            );
        } elseif ($request->user()->hasRole('manager')) {
            return response()->json(
                [
                    'message' => 'Welcome to the dashboard, Manager!',
                    'raw_material_request' => $raw_material_request,
                    'raw_material_pending' => $raw_material_pending,
                    'notifications_low_stock' => $notifications_low_stock,
                    'material_request' => $material_request
                ]
            );
        } elseif ($request->user()->hasRole('catercaptain')) {
            return response()->json(
                [
                    'message' => 'Welcome to the dashboard, CaterCaptain!',
                    'raw_material_request' => $raw_material_request,
                    'raw_material_pending' => $raw_material_pending,
                    'notifications_low_stock' => $notifications_low_stock,
                ]
            );
        } else {
            return response()->json([
                'message' => 'Welcome to the dashboard!'
            ]);
        }
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

    // Forgot Password
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

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }
}

// Dashboard function
        // Add Roles
        // Role::create(['name' => 'superadmin']);
        // Role::create(['name' => 'manager']);
        // Role::create(['name' => 'catercaptain']);

        // Role::create(['name' => 'superadmin', 'guard_name' => 'web']);
        // Role::create(['name' => 'manager', 'guard_name' => 'web']);
        // Role::create(['name' => 'catercaptain', 'guard_name' => 'web']);

        // $role = Role::all();
        // dd($role->toArray());

        // Permission
        // Permission::create(['name' => 'full']);
        // Permission::create(['name' => 'total_revenue']);
        // Permission::create(['name' => 'total_users']);
        // Permission::create(['name' => 'total_orders']);
        // Permission::create(['name' => 'pending_orders']);
        // Permission::create(['name' => 'low_stock_items']);
        // Permission::create(['name' => 'assigned_orders']);
        // Permission::create(['name' => 'today_orders']);

        // Permission::create(['name' => 'full', 'guard_name' => 'web']);
        // Permission::create(['name' => 'total_revenue', 'guard_name' => 'web']);
        // Permission::create(['name' => 'total_users', 'guard_name' => 'web']);
        // Permission::create(['name' => 'total_orders', 'guard_name' => 'web']);
        // Permission::create(['name' => 'pending_orders', 'guard_name' => 'web']);
        // Permission::create(['name' => 'low_stock_items', 'guard_name' => 'web']);
        // Permission::create(['name' => 'assigned_orders', 'guard_name' => 'web']);
        // Permission::create(['name' => 'today_orders', 'guard_name' => 'web']);

        // $permission = Permission::all();
        // dd($permission->toArray());

        // Assign Permission to Role

        // $role = Role::findByName('superadmin');
        // $role->givePermissionTo('full');
        // $role->givePermissionTo('total_revenue');
        // $role->givePermissionTo('total_users');
        // $role->givePermissionTo('total_orders');
        // $role->givePermissionTo('pending_orders');
        // $role->givePermissionTo('low_stock_items');
        // $role->givePermissionTo('assigned_orders');
        // $role->givePermissionTo('today_orders');

        // $role = Role::findByName('manager');
        // $role->givePermissionTo('pending_orders');
        // $role->givePermissionTo('low_stock_items');
        // $role->givePermissionTo('total_orders');

        // $role = Role::findByName('catercaptain');
        // $role->givePermissionTo('assigned_orders');
        // $role->givePermissionTo('today_orders');


        // $user = User::find(1);
        // $request->user()->assignRole('superadmin');
        // dd($request->user()->hasRole('superadmin'));
        // dd($user->toArray());
        // $user = User::find(2);
        // $user->assignRole('manager');
        // $user = User::find(3);
        // $user->assignRole('catercaptain');
