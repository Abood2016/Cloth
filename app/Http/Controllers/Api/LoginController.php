<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{

    //this way for one user device--not supported just for learn
    public function token(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
            'refresh' => 'boolean',
            'device' => 'required',
        ]);

        $user = User::where('name', $request->name)->first();
        if ($user && Hash::check($request->password, $user->password)) {

            if (!$user->api_token || $request->refresh == 1) {
                $token = Str::random(32);
                $user->api_token = $token;
                $user->save();
            }

            $token = $user->createToken($request->device, ['products.create']);

            return response()->json([
                'code' => 200,
                'message' => 'Login Successfully',
                'token' => $token->plainTextToken,
                'data' => $user,
            ], 200);
        }

        return response()->json([
            'code' => 0,
            'message' => 'Invalid Name or Password',
        ]);
    }


    


    public function logout(Request $request)
    {
        $user = $request->user(); // return cureent user !
        $user->api_token = null;
        $user->save();

        return response()->json([
            'code' => 200,
            'message' => 'logout Successfully',
        ], 200);
    }
}
