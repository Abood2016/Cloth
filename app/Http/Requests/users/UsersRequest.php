<?php

namespace App\Http\Requests\users;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|string|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'password' => 'required||confirmed|string|max:255|min:3',
        ];
    }
    public function messages()
    {
        return [
           
            'name.required' => 'لمستخدم مطلوب',
            'name.string' => 'لمستخدم يجب ان يكون قيمة نصية',
            'name.max' => 'لمستخدم يجب الا يتعدي 255 حرف',
            'name.min' => 'يجب كتابة 3 احرف على الأقل',
            'name.unique' => 'لمستخدم موجود مسبقآ',

            'email.required' => 'البريد مطلوب',
            'email.string' => 'البريد يجب ان يكون قيمة نصية',
            'email.unique' => 'البريد موجود مسبقآ',

            'username.required' => 'اليوزنيم مطلوب',
            'username.string' => 'اليوزنيم يجب ان يكون قيمة نصية',
            'username.unique' => 'اليوزنيم موجود مسبقآ',

            'password.required' => 'كلمة المرور مطلوبة',
            'password.string' => 'كلمة المرور يجب ان يكون قيمة نصية',
            'password.max' => 'كلمة المرور يجب الا يتعدي 255 حرف',
            'password.min' => 'يجب كتابة 3 احرف على الأقل',
        ];
    }
}
