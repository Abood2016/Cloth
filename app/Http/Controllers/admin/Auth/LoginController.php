<?php

namespace App\Http\Controllers\admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    public function __construct()
    {
    $this->middleware('guest:admin')->except('logout');
    }


    public function login()
    {
//     if you don't use middelware
    if (Auth::guard('admin')->check()) {
        return redirect()->back();
    }
         return view('admin.auth.login');
    }

    public function store(Request $request)
    {
         $request->validate([
         'name' => 'required',
         'password' => 'required',
         ],
         [
             'name.required' => 'البريد الإلكتروني مطلوب',
             'password.required' => 'كلمة المرور مطلوبة',
         ]
        );

          // $credentials = $request->only('email', 'password');
          if (!Auth::guard('admin')->attempt(
               $this->credentials($request))) {

          return back()->withErrors([
          'message' => 'خطأ في كلمة المرور او البريد'
          ]);
          }
          return redirect()->route('dashboard');
    }

     public function username()
     {
        return 'name';
     }

      protected function credentials(Request $request)
      {
          return $request->only($this->username(), 'password');
      }

         public function logout()
         {
              auth()->guard('admin')->logout();
              return redirect('dashboard/login')->with('success', 'You have been logged out');
         }


}
