<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminPermission;
use App\Models\Permission;
use App\Traits\UploadImageTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;


class AdminController extends Controller
{

  use UploadImageTrait;

  public function index()
  {
    return view('admin.admins.index');
  }


  public function AjaxDT(Request $request)
  {

    if (request()->ajax()) {
      $admins = DB::table('admins');
      $admins->select([
        'admins.*',
        DB::raw("DATE_FORMAT(admins.created_at, '%Y-%m-%d') as Date"),
      ])->get();

      return DataTables::of($admins)
        ->addColumn('actions', function ($admins) {
          $btn = "";
          if (Gate::denies('admins.edit')) {
          } else {
            $btn =  '<a href="/dashboard/admins/edit/' . $admins->id . '" class="Popup" data-toggle="modal" data-id="' . $admins->id . '" title="تعديل المدير"><i class="la la-edit icon-xl" style="color:blue;padding:4px"></i></a>';
          }
          if (Gate::denies('admins.delete')) {
          } else {
            $btn = $btn . '<a href="/dashboard/admins/delete/' . $admins->id . '" data-id="' . $admins->id . '" class="ConfirmLink "' . ' id="' . $admins->id . '"><i class="fa fa-trash-alt icon-md" style="color:red"></i></a>';
          }

          if (Gate::denies('admins.edit_permissions')) {
          } else {
            $btn = $btn . '<a href="/dashboard/admins/admin_permissions/'  . $admins->id . '" data-id="' . $admins->id . '"
                    class=" "' . ' id="' . $admins->id . '" title = "' . trans('admins/basics.title') . '"><i class="fa fa-user"
                        style="color:black;padding:6px"></i></a>';
          }
          return $btn;
        })->addColumn('image', function ($admins) {
          $url = asset('images/admins/image/' . $admins->image);
          return '<img src="' . $url . '" border="0" style="border-radius: 10px;" width="40" class="img-rounded" align="center" />';
        })->rawColumns(['actions', 'image'])->make(true);
    }
  }

  public function create()
  {
    if (!Gate::allows('admins.create')) {
      return response()->json(['status' => 2, "msg" => 'عذرآ لا تمتلك هذه الصلاحية']);
      abort(505);
    }
    return view('admin.admins.create');
  }



  public function store(Request $request)
  {
    if (Gate::denies('admins.create')) {
      abort(505);
    }

    $this->validate(
      $request,
      [
        'name' => 'required|string|max:255|min:3',
        'type' => 'required|in:super-admin,admin',
        'email' => 'required|unique:admins,email',
        'image' => 'image',
        'password' => 'required|confirmed|max:255|min:6',

      ],

      [
        'name.required' => 'اسم المدير مطلوب',
        'name.string' => 'المدير يجب ان يكون قيمة نصية',
        'name.max' => 'المدير يجب الا يتعدي 255 حرف',
        'name.min' => 'يجب كتابة 3 احرف على الأقل',
        'type.required' => 'الدور مطلوب',
        'email.required' => 'حقل البريد مطلوبة',
        'email.unique' => 'البريد الإلكتروني موجود مسبقآ',
        'image.image' => 'الرجاء إرفاق صورة غلاف',
        'password.required' => 'كلمة المرور مطلوبة',
        'password.confirmed' => 'كلمة المرور غير متطابقة',
        'password.min' => 'كلمة المرور يجب ان تكون 6 احرف على الأقل ',
      ]
    );

    date_default_timezone_set('Asia/Hebron');
    unset($request['_token']);
    $file_name = $this->saveImages($request->image, 'images/admins/image');

    $name = $request->name;
    $type = $request->type;
    $email = $request->email;
    $image = $file_name;
    $password = Hash::make($request->password);
    $updated_at = Carbon::now();
    $created_at = Carbon::now();
    DB::insert(
      'insert into admins (name,type,email,image,password,created_at,updated_at) values (?,?,?,?,?,?,?)',
      [$name, $type, $email, $image, $password, $created_at, $updated_at]
    );

    return response()->json(['status' => 1, "msg" => "تم إضافة المدير \"$name\" بنجاح"]);
  }

  public function edit($id)
  {
    if (Gate::denies('admins.edit')) {
      abort(505);
      return response()->json(['status' => 2, "msg" => 'عذرآ لا تمتلك هذه الصلاحية']);
    }

    $admin = Admin::where('id', $id)->first();
    if ($admin == null) {
      abort(404, 'المدير غير موجود');
    }
    return view('admin.admins.edit', compact('admin'));
  }


  public function update(Request $request, $id)
  {
    if (Gate::denies('admins.edit')) {
      abort(505);
      return response()->json(['status' => 2, "msg" => 'عذرآ لا تمتلك هذه الصلاحية']);
    }
    $this->validate(
      $request,
      [
        'name' => 'required|string|max:255|min:3',
        'type' => 'required|in:super-admin,admin',
        'email' => 'required|unique:admins,email,' . $id,
        'image' => 'image|nullable',
        'password' => 'nullable|max:255|min:6',
      ],
      [
        'name.required' => 'اسم المدير مطلوب',
        'name.string' => 'المدير يجب ان يكون قيمة نصية',
        'name.max' => 'المدير يجب الا يتعدي 255 حرف',
        'name.min' => 'يجب كتابة 3 احرف على الأقل',
        'type.required' => 'الدور مطلوب',
        'email.required' => 'حقل البريد مطلوبة',
        'email.unique' => 'البريد الإلكتروني موجود مسبقآ',
        'password.min' => 'كلمة المرور يجب ان تكون 6 احرف على الأقل',
      ]
    );

    $admin = Admin::where('id', $id)->first();
    $name = $request->name;
    $data = [];

    if ($request->hasFile('image')) {
      $file = $request->file('image');
      $fileName = time() . Str::random(12) . '.' . $file->getClientOriginalExtension();
      if (File::exists(public_path('/images/admins/image/') . $admin->image)) {
        File::delete(public_path('/images/admins/image/') . $admin->image);
      }
      $file->move(public_path('/images/admins/image/'), $fileName);
      $data = ['image' => $fileName] + $data;
    }

    $array = [];
    if ($request->name != $admin->name) {
      $array['name'] = $request->name;
    }

    if ($request->email != $admin->email) {
      $array['email'] = $request->email;
    }

    if ($request->type != $admin->type) {
      $array['type'] = $request->type;
    }

    if ($request->password != '') {
      $array['password'] = Hash::make($request->password);
    }

    $admin->update($data);
    if (!empty($array)) {
      $admin->update($array);
    }
    return response()->json(['status' => 1, "msg" => "تم تعديل المدير \"$name\" بنجاح"]);
  }


  public function admin_permissions($id)
  {
    $admin = Admin::find($id);
    $permissions = Permission::select('id', 'name')->get();
    return view('admin.admins.admin_permissions', ['admin' => $admin, 'permissions' => $permissions]);
  }
  

  public function set_permission(Request $request, $id)
  {
    $admin = Admin::where('id', $id)->first();
    $admin->permissions()->sync($request->name);
    return response()->json(['status' => 1, "msg" => "Permission Updated Succesfully"]);
  }

  public function AjaxDT_Permission($id)
  {
    if (request()->ajax()) {
      $admin = Admin::find($id);
      $permissions = DB::table('admins_permissions')
        ->Join('permissions', 'permissions.id', '=', 'admins_permissions.permission_id')
        ->Join('admins', 'admins.id', '=', 'admins_permissions.admin_id')
        ->select('permissions.id', 'permissions.name as permission_name', 'admins.id', 'admins.name as admin_name')
        ->where('admins_permissions.admin_id', $admin->id)
        ->get();
      return DataTables::of($permissions)->make(true);
    }
  }


  public function delete($id)
  {
    if (Gate::denies('admins.delete')) {
      return response()->json(['status' => 2, "msg" => 'عذرآ لا تمتلك هذه الصلاحية']);
      abort(505);
    }

    $admin = Admin::whereId($id)->first();
    if ($admin) {
      if (File::exists(public_path('/images/admins/image/') . $admin->image)) {
        File::delete(public_path('/images/admins/image/') . $admin->image);
      }
    }
    $admin->delete();
    return response()->json(['status' => 1, "msg" => "تم حذف المنتج \"$admin->name\" بنجاح"]);
  }
}
