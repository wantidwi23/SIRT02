<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeadOfFamily;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return view('admin.dashboard');
        }

        return view('user.dashboard');
    }

    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function userDashboard()
    {
        $headOfFamilyId = session('head_of_family_id');
        $headOfFamily = null;

        if ($headOfFamilyId) {
            $headOfFamily = HeadOfFamily::find($headOfFamilyId);
        }

        return view('user.dashboard', compact('headOfFamily'));
    }
}
