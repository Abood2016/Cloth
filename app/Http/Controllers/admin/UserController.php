<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\users\UsersRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public function index()
    {
        return view('admin.users.index');
    }


    public function AjaxDT()
    {
        if (request()->ajax()) {
            $users = DB::table('users');
            $users->select([
                'users.*',
                DB::raw("DATE_FORMAT(users.created_at, '%Y-%m-%d') as Date"),
            ])->get();

            return  DataTables::of($users)
                ->addColumn('actions', function ($users) {
                    return '<a href="/dashboard/users/edit/' . $users->id . '" class="Popup" data-toggle="modal"  data-id="' . $users->id . '"title="تعديل لمستخدم"><i class="la la-edit icon-xl" style="color:blue;padding:4px"></i></a>
                    <a href="/dashboard/users/delete/' . $users->id . '" data-id="' . $users->id . '" class="ConfirmLink "' . ' id="' . $users->id . '"><i class="fa fa-trash-alt icon-md" style="color:red"></i></a>';
                })->rawColumns(['actions'])->make(true);
        }
    }

    public function create()
    {
        return view('admin.users.create');
    }


    public function store(UsersRequest $request)
    {

        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);

        $name = $request->name;
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' =>  $request->email,
            'password' => Hash::make($request->password),
        ]);
        // DB::insert('insert into users (name,username,email,password) values (????)', [$name, $username, $email, $password]);
        return response()->json(['status' => 1, "msg" => "تم إضافة المستخدم \"$name\" بنجاح"]);
    }


    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        if ($user == null) {
            abort(404, 'المستخدم غير موجود');
        }
        return view('admin.users.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|max:255|min:3',
                'email' => 'required|email|string|unique:users,email,' . $id,
                'username' => 'required|string|unique:users,username,' . $id,
            ],
            [
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
            ]
        );

        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);

        $user = User::where('id', $id)->first();
        $username = $request->username;

        $array = [];

        if ($request->name != $user->name) {
            $array['name'] = $request->name;
        }

        if ($request->username != $user->username) {
            $array['username'] = $request->username;
        }

        if ($request->email != $user->email) {
            $array['email'] = $request->email;
        }

        if ($request->password != '') {
            $array['password'] = Hash::make($request->password);
        }
        if (!empty($array)) {
            $user->update($array);
        }
        return response()->json(['status' => 1, "msg" => "User \"$username\" Updated Succesfully"]);
    }


    public function delete($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            $user->delete();
            return response()->json(['status' => 1, "msg" => "تم حذف المستخدم  بنجاح"]);
        }
        return response()->json(['status' => 0, "msg" => "حدث خطأ ما"]);
    }
}
