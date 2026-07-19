<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\HeadOfFamily;
use Illuminate\Support\Facades\Auth;

class HeadOfFamilyDashboardController extends Controller
{
    public function index(): View
    {
        $headOfFamily = Auth::guard('head_of_family')->user();

        if (!$headOfFamily) {
            Auth::guard('head_of_family')->logout();
            return redirect('/login');
        }

        return view('head-of-family.dashboard', compact('headOfFamily'));
    }
}
