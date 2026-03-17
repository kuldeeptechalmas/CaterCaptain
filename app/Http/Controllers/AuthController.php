<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\RawMaterial;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthController extends Controller
{

    // Constructor
    protected $userRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    // Dashboard
    public function dashboard(): View
    {
        $raw_material = RawMaterial::where('is_active', true)->get();
        // dd('boom');
        return view('dashboard', ['raw_material' => $raw_material]);
    }

    // Login Page
    public function showLogin(): View
    {
        return view('auth.login');
    }

    // Registration Page
    public function showRegister(): View
    {
        return view('auth.register');
    }

    // Forgot Password Page
    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    // Change Password Page
    public function showChangePassword(): View
    {
        return view('auth.change-password');
    }

    // Login in Database
    public function login(LoginRequest $request)
    {
        $remember = (bool) $request->boolean('remember');

        if (! Auth::attempt(['email' => $request['email'], 'password' => $request['password'], 'is_active' => true], $remember)) {
            return back()->withErrors([
                'email' => 'Invalid credentials or inactive account.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('status', 'Welcome back to CaterCaptain.');
    }

    // Registration in Database
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'required|digits:10|unique:users,phone',
            'password'   => 'required|min:6|confirmed',
        ], [
            'first_name.required' => 'First name is required.',
            'last_name.required'  => 'Last name is required.',
            'email.required'      => 'Email is required.',
            'email.email'         => 'Please enter a valid email address.',
            'email.unique'        => 'This email is already registered.',
            'phone.required'      => 'Phone number is required.',
            'phone.digits'        => 'Phone number must be 10 digits.',
            'phone.unique'        => 'This phone number already exists.',
            'password.required'   => 'Password is required.',
            'password.min'        => 'Password must be at least 6 characters.',
            'password.confirmed'  => 'Password confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'password'    => Hash::make($request->password),
            'user_number' => $this->generateUserNumber(),
            'is_active'   => true,
        ];

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->user_number = $this->generateUserNumber();
        $user->is_active = true;
        $user->save();

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('status', 'Registration successful.');
    }

    // Forgot Password in Database
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $user = $this->userRepo->findByEmail($request->email);

        if (! $user || ! $user->is_active) {

            return back()->withErrors([
                'email' => 'Account is inactive or not found.',
            ])->withInput();
        }

        $this->userRepo->updatePassword($user->id, Hash::make($request->password));

        return redirect()->route('logins')->with('status', 'Password updated successfully. Please login.');
    }

    // Change Password in Database
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        $this->userRepo->updatePassword($user->id, Hash::make($request->password));

        return redirect()->route('dashboard')->with('status', 'Password changed successfully.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('logins')->with('status', 'You are logged out.');
    }


    private function generateUserNumber(): string
    {
        do {
            $number = 'USR-' . date('Y') . '-' . str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (User::where('user_number', $number)->exists());

        return $number;
    }

    public function materialReport(Request $request)
    {
        $materials = $this->buildMaterialReportQuery($request)
            ->orderBy('raw_materials.name')
            ->get();

        $units = DB::table('units')->where('is_active', true)->orderBy('name')->get();
        $kitchens = DB::table('kitchens')->where('is_active', true)->orderBy('name')->get();
        $storeCount = (clone $this->buildMaterialReportQuery($request))
            ->distinct('raw_materials.location_id')
            ->count('raw_materials.location_id');

        $hasFilters = $request->filled('q')
            || $request->filled('unit_id')
            || $request->filled('kitchen_id')
            || $request->filled('status')
            || $request->filled('qty_min')
            || $request->filled('qty_max');

        $moments = collect();
        if ($hasFilters && $materials->isNotEmpty()) {
            $materialIds = $materials->pluck('id')->all();
            $moments = DB::table('raw_material_moment')
                ->leftJoin('raw_materials', 'raw_material_moment.raw_material_id', '=', 'raw_materials.id')
                ->leftJoin('units', 'raw_material_moment.unit_id', '=', 'units.id')
                ->leftJoin('kitchens as from_kitchen', 'raw_material_moment.from_kitchen_id', '=', 'from_kitchen.id')
                ->leftJoin('kitchens as to_kitchen', 'raw_material_moment.to_kitchen_id', '=', 'to_kitchen.id')
                ->leftJoin('hq_details as from_hq', 'raw_material_moment.from_hq_id', '=', 'from_hq.id')
                ->leftJoin('hq_details as to_hq', 'raw_material_moment.to_hq_id', '=', 'to_hq.id')
                ->select(
                    'raw_material_moment.*',
                    'raw_materials.name as material_name',
                    'units.symbol as unit_symbol',
                    'from_kitchen.name as from_kitchen_name',
                    'to_kitchen.name as to_kitchen_name',
                    'from_hq.value as from_hq_value',
                    'to_hq.value as to_hq_value'
                )
                ->whereIn('raw_material_moment.raw_material_id', $materialIds)
                ->orderBy('raw_material_moment.created_at')
                ->get();
        }

        return view("auth.material-report", [
            'materials' => $materials,
            'units' => $units,
            'kitchens' => $kitchens,
            'storeCount' => $storeCount,
            'moments' => $moments,
            'hasFilters' => $hasFilters,
        ]);
    }

    public function materialReportPdf(Request $request)
    {
        $pdfClass = '\\Barryvdh\\DomPDF\\Facade\\Pdf';

        if (!class_exists($pdfClass)) {
            return response('PDF not configured. Please install laravel-dompdf.', 501);
        }

        $materials = $this->buildMaterialReportQuery($request)
            ->orderBy('raw_materials.name')
            ->get();

        $hasFilters = $request->filled('q')
            || $request->filled('unit_id')
            || $request->filled('kitchen_id')
            || $request->filled('status')
            || $request->filled('qty_min')
            || $request->filled('qty_max');

        $moments = collect();
        if ($hasFilters && $materials->isNotEmpty()) {
            $materialIds = $materials->pluck('id')->all();
            $moments = DB::table('raw_material_moment')
                ->leftJoin('raw_materials', 'raw_material_moment.raw_material_id', '=', 'raw_materials.id')
                ->leftJoin('units', 'raw_material_moment.unit_id', '=', 'units.id')
                ->leftJoin('kitchens as from_kitchen', 'raw_material_moment.from_kitchen_id', '=', 'from_kitchen.id')
                ->leftJoin('kitchens as to_kitchen', 'raw_material_moment.to_kitchen_id', '=', 'to_kitchen.id')
                ->leftJoin('hq_details as from_hq', 'raw_material_moment.from_hq_id', '=', 'from_hq.id')
                ->leftJoin('hq_details as to_hq', 'raw_material_moment.to_hq_id', '=', 'to_hq.id')
                ->select(
                    'raw_material_moment.*',
                    'raw_materials.name as material_name',
                    'units.symbol as unit_symbol',
                    'from_kitchen.name as from_kitchen_name',
                    'to_kitchen.name as to_kitchen_name',
                    'from_hq.value as from_hq_value',
                    'to_hq.value as to_hq_value'
                )
                ->whereIn('raw_material_moment.raw_material_id', $materialIds)
                ->orderBy('raw_material_moment.created_at')
                ->get();
        }

        $pdf = $pdfClass::loadView('auth.material-report-pdf', [
            'materials' => $materials,
            'moments' => $moments,
        ]);

        return $pdf->stream('material-report.pdf');
    }

    public function materialReportPdfDownload(Request $request)
    {
        $pdfClass = '\\Barryvdh\\DomPDF\\Facade\\Pdf';

        if (!class_exists($pdfClass)) {
            return response('PDF not configured. Please install laravel-dompdf.', 501);
        }

        $materials = $this->buildMaterialReportQuery($request)
            ->orderBy('raw_materials.name')
            ->get();

        $hasFilters = $request->filled('q')
            || $request->filled('unit_id')
            || $request->filled('kitchen_id')
            || $request->filled('status')
            || $request->filled('qty_min')
            || $request->filled('qty_max');

        $moments = collect();
        if ($hasFilters && $materials->isNotEmpty()) {
            $materialIds = $materials->pluck('id')->all();
            $moments = DB::table('raw_material_moment')
                ->leftJoin('raw_materials', 'raw_material_moment.raw_material_id', '=', 'raw_materials.id')
                ->leftJoin('units', 'raw_material_moment.unit_id', '=', 'units.id')
                ->leftJoin('kitchens as from_kitchen', 'raw_material_moment.from_kitchen_id', '=', 'from_kitchen.id')
                ->leftJoin('kitchens as to_kitchen', 'raw_material_moment.to_kitchen_id', '=', 'to_kitchen.id')
                ->leftJoin('hq_details as from_hq', 'raw_material_moment.from_hq_id', '=', 'from_hq.id')
                ->leftJoin('hq_details as to_hq', 'raw_material_moment.to_hq_id', '=', 'to_hq.id')
                ->select(
                    'raw_material_moment.*',
                    'raw_materials.name as material_name',
                    'units.symbol as unit_symbol',
                    'from_kitchen.name as from_kitchen_name',
                    'to_kitchen.name as to_kitchen_name',
                    'from_hq.value as from_hq_value',
                    'to_hq.value as to_hq_value'
                )
                ->whereIn('raw_material_moment.raw_material_id', $materialIds)
                ->orderBy('raw_material_moment.created_at')
                ->get();
        }

        $pdf = $pdfClass::loadView('auth.material-report-pdf', [
            'materials' => $materials,
            'moments' => $moments,
        ]);

        return $pdf->download('material-report.pdf');
    }

    public function pettyCashReport(Request $request)
    {
        $issues = $this->buildPettyCashReportQuery($request)
            ->orderByDesc('petty_cash_issues.issue_date')
            ->get();

        $users = DB::table('users')->where('is_active', true)->orderBy('first_name')->get();

        return view('auth.petty-cash-report', [
            'issues' => $issues,
            'users' => $users,
        ]);
    }

    public function pettyCashReportPdf(Request $request)
    {
        $pdfClass = '\\Barryvdh\\DomPDF\\Facade\\Pdf';

        if (!class_exists($pdfClass)) {
            return response('PDF not configured. Please install laravel-dompdf.', 501);
        }

        $issues = $this->buildPettyCashReportQuery($request)
            ->orderByDesc('petty_cash_issues.issue_date')
            ->get();

        $pdf = $pdfClass::loadView('auth.petty-cash-report-pdf', [
            'issues' => $issues,
        ]);

        return $pdf->stream('petty-cash-report.pdf');
    }

    public function pettyCashReportPdfDownload(Request $request)
    {
        $pdfClass = '\\Barryvdh\\DomPDF\\Facade\\Pdf';

        if (!class_exists($pdfClass)) {
            return response('PDF not configured. Please install laravel-dompdf.', 501);
        }

        $issues = $this->buildPettyCashReportQuery($request)
            ->orderByDesc('petty_cash_issues.issue_date')
            ->get();

        $pdf = $pdfClass::loadView('auth.petty-cash-report-pdf', [
            'issues' => $issues,
        ]);

        return $pdf->download('petty-cash-report.pdf');
    }

    private function buildMaterialReportQuery(Request $request)
    {
        $latestPricingIds = DB::table('material_pricing')
            ->select('raw_material_id', DB::raw('MAX(id) as latest_id'))
            ->whereNull('deleted_at')
            ->groupBy('raw_material_id');

        $query = DB::table('raw_materials')
            ->leftJoin('units', 'raw_materials.unit_id', '=', 'units.id')
            ->leftJoin('kitchens', 'raw_materials.location_id', '=', 'kitchens.id')
            ->leftJoin('hq_details as hq_detail', 'raw_materials.hq_id', '=', 'hq_detail.id')
            ->leftJoinSub($latestPricingIds, 'latest_price_ids', function ($join) {
                $join->on('raw_materials.id', '=', 'latest_price_ids.raw_material_id');
            })
            ->leftJoin('material_pricing as latest_price', 'latest_price.id', '=', 'latest_price_ids.latest_id')
            ->select(
                'raw_materials.*',
                'units.name as unit_name',
                'units.symbol as unit_symbol',
                'kitchens.name as kitchen_name',
                'hq_detail.key as hq_key',
                'hq_detail.value as hq_value',
                'latest_price.pricing_date as pricing_date',
                'latest_price.price_unit as price_unit',
                'latest_price.price_kg as price_kg',
                'latest_price.price_litre as price_litre',
                'latest_price.price_piece as price_piece',
                DB::raw("CASE raw_materials.unit_id
                    WHEN 1 THEN latest_price.price_kg
                    WHEN 2 THEN latest_price.price_unit
                    WHEN 3 THEN latest_price.price_litre
                    WHEN 4 THEN latest_price.price_piece
                    ELSE latest_price.price_unit
                END as material_price")
            );

        if ($request->filled('q')) {
            $q = trim((string) $request->q);
            $query->where('raw_materials.name', 'like', '%' . $q . '%');
        }

        if ($request->filled('unit_id')) {
            $query->where('raw_materials.unit_id', (int) $request->unit_id);
        }

        if ($request->filled('kitchen_id')) {
            $query->where('raw_materials.location_id', (int) $request->kitchen_id);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('raw_materials.is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('raw_materials.is_active', false);
            }
        } else {
            $query->where('raw_materials.is_active', true);
        }

        return $query;
    }

    private function buildPettyCashReportQuery(Request $request)
    {
        $query = DB::table('petty_cash_issues')
            ->leftJoin('users as captains', 'petty_cash_issues.captain_id', '=', 'captains.id')
            ->leftJoin('users as creators', 'petty_cash_issues.created_by', '=', 'creators.id')
            ->select(
                'petty_cash_issues.*',
                DB::raw("TRIM(CONCAT(captains.first_name, ' ', captains.last_name)) as captain_name"),
                DB::raw("TRIM(CONCAT(creators.first_name, ' ', creators.last_name)) as created_by_name")
            );

        if ($request->filled('q')) {
            $q = trim((string) $request->q);
            $query->where(function ($builder) use ($q) {
                $builder->where('captains.first_name', 'like', '%' . $q . '%')
                    ->orWhere('captains.last_name', 'like', '%' . $q . '%');
            });
        }

        if ($request->filled('captain_id')) {
            $query->where('petty_cash_issues.captain_id', (int) $request->captain_id);
        }

        if ($request->filled('created_by')) {
            $query->where('petty_cash_issues.created_by', (int) $request->created_by);
        }

        if ($request->filled('date_from')) {
            $query->where('petty_cash_issues.issue_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('petty_cash_issues.issue_date', '<=', $request->date_to);
        }

        if ($request->filled('amount_min')) {
            $query->where('petty_cash_issues.amount', '>=', (float) $request->amount_min);
        }

        if ($request->filled('amount_max')) {
            $query->where('petty_cash_issues.amount', '<=', (float) $request->amount_max);
        }

        return $query;
    }
}
