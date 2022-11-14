<?php

namespace App\Http\Controllers\admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{

    use ResetsPasswords;
    protected $redirectTo = RouteServiceProvider::HOME;


    public function broker()
    {
      return Password::broker('admins');
    }

    
    public function guard()
    {
    return Auth::guard('admin');
    }
    
    public function showResetForm(Request $request)
    {
    $token = $request->route()->parameter('token');

    return view('admin.auth.passwords.reset')->with(
    ['token' => $token, 'email' => $request->email]
    );
    }


     public function reset(Request $request, $token = null)
     {
     return view('admin.auth.passwords.reset')->with(
     ['token' => $token, 'email' => $request->email]
     );
     }

}
