<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\UserStatus;
use App\UserType;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm(Request $request){
        $data = [
            'pageTitle'=>'login'
        ];
        return view('back.pages.auth.login',$data);
    }

    public function forgotForm(Request $request){

        $data = [
            'pageTitle'=> 'Forgot Password'
        ];
        return view('back.pages.auth.forgot', $data);
    }

    public function login_handler(Request $request){

        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email': 'username';
        if($fieldType=='email'){
            $request->validate([
                'login_id'=> 'required|email|exists:users,email',
                'password'=>'required|min:5'
            ],[
                'login_id.required'=> 'Enter your email or username',
                'login_id.email'=> 'Invalid email address',
                'login_id.exists'=> 'No account found for this email '
            ]);
        }else{

            $request->validate([
                'login_id'=> 'required|exists:users,username',
                'password'=>'required|min:5'
            ],[
                'login_id.required'=> 'Enter your username or email',
                'login_id.exists'=> 'No account found for this username',

            ]);
        }

        $creds = array(
            $fieldType=>$request->login_id,
            'password'=> $request->password,
        );
        if(Auth::attempt($creds)){

            // check if account Inactive

            if(auth()->user()->status== UserStatus::Inactive){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->with('fail', 'your account is currentaly inactive. plzz contact support (support@larablogapp) for further assistance');

            }
                // check if account is in pending mode
            if(auth()->user()->status==UserStatus::Pending){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->with('fail', 'Your account is currentaly in pending approval plzz check your email for further instruction or  contact support (support@larablogapp) for further assistance ');
            }

            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->route('admin.login')->withInput()->with('fail', 'Incorrect password');
        }
    }
}
