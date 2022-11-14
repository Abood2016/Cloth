<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomLoginController extends Controller
{
    public function showLoginform()
    {
        return view('auth.login');
    }


     public function login(Request $request)
     {
        $request->validate([
            'username' =>'required',
            'password' =>'required',
        ]);

        // $result = Auth::guard('web')->attempt([
        //     'username' => $request->username,
        //     'password' => $request->password,
        // ]);

        //login by username or email
        $user = User::where('username',$request->username)
        ->orWhere('email',$request->username)
        ->first();

        if($user && Hash::check($request->password,$user->password))
        {
             Auth::login($user);
            return route('index',[App::getLocale()]);
        }

        return redirect()
        ->back()
        ->withInput()
        ->with('alert.erorr','Invalid Username OR Password');
     }

     public function logout(Request $request)
     {
     $this->guard('web')->logout();

     $request->session()->invalidate();

     $request->session()->regenerateToken();

     if ($response = $this->loggedOut($request)) {
     return $response;
     }

     return $request->wantsJson()
     ? new JsonResponse([], 204)
     : redirect('/');
     }

     protected function loggedOut(Request $request)
     {
        return redirect($this->redirectTo());
     }


    // public function logout()
    // {
    //     auth()->guard('web')->logout();
    //     return redirect('/')->with('success', 'You have been logged out');
    // }
}
