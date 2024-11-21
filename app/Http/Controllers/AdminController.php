<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

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

    public function profileView(Request $request){

        $data = [
            'pageTitle'=> 'Profile'

        ];
        return view('back.pages.profile', $data);
    }// End METHOD
}
