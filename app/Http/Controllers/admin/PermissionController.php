<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    public function index()
    {
        return view('admin.permissions.index');
    }

    public function AjaxDT(Request $request)
    {
        if (request()->ajax()) {
            $permissions = DB::table('permissions');

            $permissions->select([
                'permissions.*',
                DB::raw("DATE_FORMAT(permissions.created_at, '%Y-%m-%d') as Date"),
            ])->get();

            return  DataTables::of($permissions)
                ->addColumn('actions', function ($permissions) {
                    return '<a href="/dashboard/permissions/edit/' . $permissions->id . '" class="Popup" data-toggle="modal"  data-id="' . $permissions->id . '"title= "' . trans("permissions/basics.title") . '"><i class="la la-edit icon-xl" style="color:blue;padding:4px"></i></a>
                            <a href="/dashboard/permissions/delete/' . $permissions->id . '" data-id="' . $permissions->id . '" class="ConfirmLink "' . ' id="' . $permissions->id . '"><i class="fa fa-trash-alt icon-md" style="color:red"></i></a>';
                })->rawColumns(['actions'])->make(true);
        }
    }


    public function create()
    {
        return view('admin.permissions.create');
    }


    public function store(Request $request)
    {

        $this->validate(
            $request,
            [
                'name' => 'required|string|max:255|min:3|unique:permissions,name',
            ],
            [
                'name.required' => trans('permissions/validation.name'),
                'name.string' => trans('permissions/validation.string'),
                'name.max' => trans('permissions/validation.max'),
                'name.min' => trans('permissions/validation.min'),
                'name.unique' => trans('permissions/validation.unique'),
            ]
        );

        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);

        $permission_name = $request->name;
        $updated_at = Carbon::now();
        $created_at = Carbon::now();
        DB::insert('insert into permissions (name,created_at,updated_at) values (?,?,?)', [$permission_name, $created_at, $updated_at]);
        return response()->json(['status' => 1, "msg" => trans('permissions/basics.success msg') . " " . "\"$permission_name\"" . " " . trans('permissions/basics.success')]);
    }

    public function edit($id)
    {
        $permission = Permission::where('id', $id)->first();
        if (!$permission) {
            abort('No Permission Found');
        }
        return view('admin.permissions.edit', ['permission' => $permission]);
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|max:255|min:3|unique:permissions,name,' . $id,
            ],
            [
                'name.required' => trans('permissions/validation.name'),
                'name.string' => trans('permissions/validation.string'),
                'name.max' => trans('permissions/validation.max'),
                'name.min' => trans('permissions/validation.min'),
                'name.unique' => trans('permissions/validation.unique'),
            ]
        );

        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);
        $permission_name = $request->name;
        $updated_at = Carbon::now(); // only with db::update query

        $query = DB::table('permissions')
            ->where('id', $id)
            ->update([
                'name' => $permission_name,
                'updated_at' => $updated_at
            ]);
        if ($query) {
            return response()->json(['status' => 1, 'msg' => "Permission \"$permission_name\" Updated Successfully"]);
        }
    }

    public function delete($id)
    {
        $permission = Permission::where('id', $id)->first();
        if (!$permission) {
            return response()->json(['status' => 1, 'msg' => "Permission not Found !"]);
        }
        $permission->delete();
        return response()->json(['status' => 1, 'msg' => "Permission deleted Successfully"]);
    }
}
