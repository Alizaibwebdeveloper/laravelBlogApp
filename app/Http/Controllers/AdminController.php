<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\File;
use SawaStacks\Utils\Kropify;


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
   public function updateProfilePicture(Request $request)
{
    $user = auth()->user();

    // Validate the uploaded file
    $request->validate([
        'profilePictureFile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
    ]);

    $path = 'images/users/';
    $file = $request->file('profilePictureFile');
    $old_picture = $user->picture;
    $fileName = 'IMG_' . uniqid() . '.png';

    // Process and save the image using Kropify
    try {
        $upload = Kropify::getFile($file, $fileName)->maxWoH(255)->save(public_path($path));

        if ($upload) {
            // Delete old picture if exists
            if (!empty($old_picture) && File::exists(public_path($path . $old_picture))) {
                File::delete(public_path($path . $old_picture));
            }

            // Update user's profile picture in the database
            $user->update(['picture' => $fileName]);

            return response()->json([
                'status' => 1,
                'message' => 'Your profile picture has been updated successfully',
            ]);
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => 0,
            'message' => 'Something went wrong while processing the image',
            'error' => $e->getMessage(),
        ]);
    }

    return response()->json([
        'status' => 0,
        'message' => 'Something went wrong while uploading the image',
    ]);
}

}
