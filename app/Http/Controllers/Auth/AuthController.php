<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\HeadOfFamily;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * Display the login form.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Try to login as User (admin/petugas)
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            $request->session()->regenerate();

            $authenticatedUser = Auth::user();

            // Check if user is active
            if (!$authenticatedUser->active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda telah dinonaktifkan.',
                ])->onlyInput('email');
            }

            if ($authenticatedUser->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('user.dashboard');
        }

        // Try to login as HeadOfFamily
        $headOfFamily = HeadOfFamily::where('email', $validated['email'])->first();
        
        if ($headOfFamily && Hash::check($validated['password'], $headOfFamily->password)) {
            // Check if active
            if (!$headOfFamily->active) {
                return back()->withErrors([
                    'email' => 'Akun Anda telah dinonaktifkan.',
                ])->onlyInput('email');
            }

            // Store HeadOfFamily in session
            session([
                'head_of_family_id' => $headOfFamily->id,
                'head_of_family_name' => $headOfFamily->nama,
                'head_of_family_email' => $headOfFamily->email,
            ]);
            
            return redirect()->route('user.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        // Forget HeadOfFamily session if exists
        session()->forget(['head_of_family_id', 'head_of_family_name']);
        
        // Logout user if exists
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Display the change password form.
     */
    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    /**
     * Handle password change request.
     */
    public function updatePassword(Request $request)
    {
        // Check if HeadOfFamily is logged in
        $isHeadOfFamily = session('head_of_family_id') !== null;

        if ($isHeadOfFamily) {
            // Validate for HeadOfFamily
            $validated = $request->validate([
                'current_password' => ['required'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ], [
                'current_password.required' => 'Password saat ini wajib diisi.',
                'password.required' => 'Password baru wajib diisi.',
                'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            ]);

            $headOfFamily = HeadOfFamily::find(session('head_of_family_id'));

            // Check if current password is correct
            if (!Hash::check($validated['current_password'], $headOfFamily->password)) {
                return back()->withErrors([
                    'current_password' => 'Password saat ini tidak sesuai.',
                ])->onlyInput('current_password');
            }

            // Update password
            $headOfFamily->update([
                'password' => Hash::make($validated['password']),
            ]);

            return redirect()->back()->with('success', 'Password berhasil diubah.');
        } else {
            // Validate for User
            $validated = $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ], [
                'current_password.required' => 'Password saat ini wajib diisi.',
                'current_password.current_password' => 'Password saat ini tidak sesuai.',
                'password.required' => 'Password baru wajib diisi.',
                'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            ]);

            $user = Auth::user();
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);

            return redirect()->back()->with('success', 'Password berhasil diubah.');
        }
    }
}
