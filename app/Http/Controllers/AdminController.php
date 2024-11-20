<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminDashboard(Request $request){
        $data = [
            'pageTitle' => 'Dashboard'
        ];

        return view('back.pages.dashboard', $data);
    }

    public function logoutHandler(Request $request){

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('fail', 'You are now logout');
        
    }
    // End method
}
