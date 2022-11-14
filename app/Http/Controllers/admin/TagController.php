<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
{
    public function index()
    {
        return view('admin.tags.index');
    }


    public function store(Request $request)
    {

        $this->validate(
            $request,
            [
                'name' => 'required|string|max:255|min:3|unique:tags,name',
            ],
            [
                'name.required' => 'الوسم مطلوب',
                'name.string' => 'الوسم يجب ان يكون قيمة نصية',
                'name.max' => 'الوسم يجب الا يتعدي 255 حرف',
                'name.min' => 'يجب كتابة 3 احرف على الأقل',
                'name.unique' => 'الوسم موجود مسبقآ',
            ]
        );

        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);

        $tag_name = $request->name;
        DB::insert('insert into tags (name) values (?)', [$tag_name]);
        return response()->json(['status' => 1, "msg" => "تم إضافة الوسم \"$tag_name\" بنجاح"]);
    }


    public function AjaxDT(Request $request)
    {
        if (request()->ajax()) {
            $tags = DB::table('tags');

            $tags->select([
                'tags.*',
            ])->get();

            return  DataTables::of($tags)
                ->addColumn('actions', function ($tags) {
                    return '<a href="/dashboard/tags/edit/' . $tags->id . '" class="Popup" data-toggle="modal"  data-id="' . $tags->id . '"title="تعديل الوسم"><i class="la la-edit icon-xl" style="color:blue;padding:4px"></i></a>
                            <a href="/dashboard/tags/delete/' . $tags->id . '" data-id="' . $tags->id . '" class="ConfirmLink "' . ' id="' . $tags->id . '"><i class="fa fa-trash-alt icon-md" style="color:red"></i></a>';
                })
                ->rawColumns(['actions'])->make(true);
        }
    }


    public function create()
    {
        return view('admin.tags.create');
    }


    public function edit($id)
    {
        $tag = Tag::where('id', $id)->first();
        if ($tag == null) {
            abort(404, 'الوسم غير موجود');
        }
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|max:255|min:3|unique:tags,name,' . $id,
            ],
            [
                'name.required' => 'الوسم مطلوب',
                'name.string' => 'الوسم يجب ان يكون قيمة نصية',
                'name.max' => 'الوسم يجب الا يتعدي 255 حرف',
                'name.min' => 'يجب كتابة 3 احرف على الأقل',
                'name.unique' => 'الوسم موجود مسبقآ',
            ]
        );

        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);

        $tag_name = $request->name;

        $query = DB::table('tags')
            ->where('id', $id)
            ->update(['name' => $tag_name]);
        if ($query) {
            return response()->json(['status' => 1, "msg" => "تم تعديل الوسم \"$tag_name\" بنجاح"]);
        }
    }

    public function delete($id)
    {
        $tag = Tag::where('id', $id)->first();
        if ($tag) {
            $tag->delete();
            return response()->json(['status' => 1, "msg" => "تم حذف الوسم \"$tag->name\" بنجاح"]);
        }
        return response()->json(['status' => 0, "msg" => "حدث خطأ ما"]);
    }
}
