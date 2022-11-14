<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function updateProfile(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'code' => 404,
                'message' => 'User Not Found !'
            ]);
        }
        $request->validate(
            [
                'name' => 'required|string|max:255|min:3,' . $user->id,

            ],
            [
                'name.required' => trans('userValidationApi.UsernameRequired'),
                'name.string' => 'لمستخدم يجب ان يكون قيمة نصية',
                'name.max' => 'لمستخدم يجب الا يتعدي 255 حرف',
                'name.min' => 'يجب كتابة 3 احرف على الأقل',
                'name.unique' => 'لمستخدم موجود مسبقآ',

            ]
        );

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email
        ]);

        if ($user) {
            return response()->json([
                'code' => 200,
                'message' => 'Profile Updated Successfully',
                'data' => $user,
            ]);
        }
    }
}
