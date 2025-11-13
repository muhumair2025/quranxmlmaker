<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AdminController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Show admin dashboard
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.index', compact('users'));
    }

    /**
     * Show create user form
     */
    public function create()
    {
        return view('admin.create-user');
    }

    /**
     * Store new user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => false,
        ]);

        // Generate and send OTP for new user
        $otp = $this->otpService->generateOtp();
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
            'otp_verified' => false,
        ]);

        $this->otpService->sendOtp($user, $otp);

        return redirect()->route('admin.index')->with('success', 'User created successfully! OTP has been sent to their email.');
    }

    /**
     * Show edit user form
     */
    public function edit(User $user)
    {
        return view('admin.edit-user', compact('user'));
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', PasswordRule::defaults()],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('admin.index')->with('success', 'User updated successfully!');
    }

    /**
     * Delete user
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.index')->with('error', 'You cannot delete your own account.');
        }

        // Prevent deleting the only admin
        if ($user->is_admin && User::where('is_admin', true)->count() <= 1) {
            return redirect()->route('admin.index')->with('error', 'Cannot delete the only admin user.');
        }

        $user->delete();

        return redirect()->route('admin.index')->with('success', 'User deleted successfully!');
    }
}

