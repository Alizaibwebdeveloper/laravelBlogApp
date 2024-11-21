<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\UserStatus;
use App\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Helpers\CMail;


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
    } // End Method

    public function SendPasswordResetLink(Request $request){

        // validatet the form

        $request->validate([
            'email'=> 'required|email|exists:users,email',

        ],[
            'email.required'=> 'The :attribute is required',
            'email.email'=> 'Invalid email address',
            'email.exists'=> 'we cannot find any user with this email address'
        ]);

        // get UserDetail

        $user = User::where('email', $request->email)->first();

        // Generate Token 

        $token = base64_encode(Str::random(64));

        // check if there is an existing token

        $oldToken = DB::table('password_reset_tokens')
                    ->where('email', $user->email)
                    ->first();

        if($oldToken){
            DB::table('password_reset_tokens')
            ->where('email', $user->email)
            ->update([
                'token'=>$token,
                'created_at'=> Carbon::now(),

            ]);
        }else{
            // Add new password reset Token 
            DB::table('password_reset_tokens')->insert([
                'email'=> $user->email,
                'token'=> $token,
                'created_at'=> Carbon::now()
            ]);

        }

        // Create clickable action link

        $actionLink = route('admin.reset_password_form',['token'=> $token]);
        $data = array(
            'actionlink'=> $actionLink,
            'user'=> $user
        );
        
        $mailBody = view('email-templates.forgot-template', $data)->render();
        $mailConfig = array(
            'recipient_address'=> $user->email,
            'recipient_name'=> $user->name,
            'subject'=> 'Reset password',
            'body'=> $mailBody,

        );

        if(CMail::send($mailConfig)){
            return redirect()->route('admin.forgot')->with('success', 'We have e-mailed your password reset link.');
        }else{
            return redirect()->route('admin.forgot')->with('fail', 'Something went wrong password Resetting link not sent. Try again later.');
        }
    } // End Method

    public function resetForm(Request $request ,$token  = null){

        // check if this token is exists

        $isTokenExists = DB::table('password_reset_tokens')
                   ->where('token', $token)->first();

        if(!$isTokenExists){
            return redirect()->route('admin.forgot')->with('fail', 'Invalid Token.  Request another reset password link.');
        }else{
            $data =[
                'pageTitle'=>'Reset Password',
                'token'=> $token,

            ];
            return view('back.pages.auth.reset', $data);
        }
    }//End Method

    public function resetPasswordHandler(Request $request){

        $request->validate([
            'new_password'=> 'required|min:5|required_with:new_password_confirmation|same:new_password_confirmation',
            'new_password_confirmation'=>'required'
        ]);

        $dbToken = DB::table('password_reset_tokens')
        ->where('token', $request->token)->first();

        // get User Detail
         $user = User::where('email', $dbToken->email)->first();

         // Update Password

         User::where('email', $user->email)->update([
            'password'=> Hash::make($request->new_password)

         ]);

         // Send notification to this user email Address

         $data = array(
            'user'=> $user,
            'new_password'=> $request->new_password,
         );
         $mail_body = view('email-templates.password-changes-template', $data)->render();
         $mailConfig = array(
            'recipient_address'=> $user->email,
            'recipient_name'=> $user->name,
            'subject'=> 'password Changed',
            'body'=>  $mail_body,

        );

        if(CMail::send($mailConfig)){

            DB::table('password_reset_tokens')->where([
                'email'=> $dbToken->email,
                'token'=> $dbToken->token

            ])->delete();
            return redirect()->route('admin.login')->with('success', 'Done, Your password has been changed Successfully. Use your new password for login to system');
        }else{
            return redirect()->route('admin.reset_password_form', ['token'=>$dbToken->token])->with('fail', 'Something went wrong . Try again later');
        }
    }

}
