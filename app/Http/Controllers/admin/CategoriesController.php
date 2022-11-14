<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{

    public function index()
    {
        if (Gate::denies('categories.index')) {
            abort('505');
        }
        return view('admin.categories.index');
    }


    public function store(Request $request)
    {

        $this->validate(
            $request,
            [
                'name' => 'required|string|max:255|min:3|unique:categories,name',
                'status' => 'required|in:published,draft',
                'parent_id' => 'nullable|int|exists:categories,id',
            ],
            [
                'name.required' => 'التصنيف مطلوب',
                'name.string' => 'الصنف يجب ان يكون قيمة نصية',
                'name.max' => 'الصنف يجب الا يتعدي 255 حرف',
                'name.min' => 'يجب كتابة 3 احرف على الأقل',
                'name.unique' => 'الصنف موجود مسبقآ',
                'parent_id.int' => 'يجب ان تكون قيمة الصنف الأب رقمية',
                'status.required' => 'حقل الحالة مطلوبة',
                'status.in' => 'يجب ان تكون الحالة اما معروضة أو معطلة',
            ]
        );

        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);

        $cat_name = $request->name;
        $cat_parent_id = $request->parent_id;
        $cat_status = $request->status;
        $updated_at = Carbon::now();
        $created_at = Carbon::now();
        DB::insert('insert into categories (name,parent_id,status,created_at,updated_at) values (?,?,?,?,?)', [$cat_name, $cat_parent_id, $cat_status, $created_at, $updated_at]);
        return response()->json(['status' => 1, "msg" => trans('category.Category Added Succesfully') . " " . "\"$cat_name\"" . " " . trans('category.Success')]);
    }


    public function AjaxDT(Request $request)
    {
        if (request()->ajax()) {
            $categories = DB::table('categories')
                ->leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
                ->leftJoin('products', 'products.category_id', '=', 'categories.id');

            $categories->select([
                'categories.*', 'parents.name as parent_name',
                DB::raw("DATE_FORMAT(categories.created_at, '%Y-%m-%d') as Date"),
                DB::raw("count(products.id) as product_count")
            ])->groupBy('categories.id', 'categories.name')->get();

            return  DataTables::of($categories)
                ->addColumn('actions', function ($categories) {
                    return '<a href="/dashboard/categories/edit/' . $categories->id . '" class="Popup" data-toggle="modal"  data-id="' . $categories->id . '"title="تعديل الصنف"><i class="la la-edit icon-xl" style="color:blue;padding:4px"></i></a>
                            <a href="/dashboard/categories/delete/' . $categories->id . '" data-id="' . $categories->id . '" class="ConfirmLink "' . ' id="' . $categories->id . '"><i class="fa fa-trash-alt icon-md" style="color:red"></i></a>
                            <a href="/dashboard/categories/show/' . $categories->id . '" data-id="' . $categories->id . '" title="عرض منتجات الصنف"><i class="fas fa-align-justify pl-2" style="color:#28B463"></i></a>';
                })->editColumn('status', function ($categories) {
                    return ($categories->status == 'published') ? "<span class='badge badge-primary'>$categories->status</span>" : "<span class='badge badge-success'>$categories->status</span>";
                })->editColumn('parent_name', function ($categories) {
                    return ($categories->parent_name == NULL) ? "لا يوجد أب" : "$categories->parent_name";
                })
                ->rawColumns(['actions', 'status', 'parent_name'])->make(true);
        }
    }

    public function show($id)
    {
        $category = Category::where('id', $id)->first();
        return view('admin.categories.show', compact('category'));
    }


    public function create()
    {
        return view('admin.categories.create');
    }


    public function edit($id)
    {
        $category = Category::where('id', $id)->first();
        if ($category == null) {
            abort(404, 'الصنف غير موجود');
        }
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|max:255|min:3|unique:categories,name,' . $id,
                'status' => 'required|in:published,draft',
                'parent_id' => 'nullable|int|exists:categories,id',
            ],
            [
                'name.required' => 'التصنيف مطلوب',
                'name.string' => 'الصنف يجب ان يكون قيمة نصية',
                'name.max' => 'الصنف يجب الا يتعدي 255 حرف',
                'name.min' => 'يجب كتابة 3 احرف على الأقل',
                'name.unique' => 'الصنف موجود مسبقآ',
                'parent_id.int' => 'يجب ان تكون قيمة الصنف الأب رقمية',
                'status.required' => 'حقل الحالة مطلوبة',
                'status.in' => 'يجب ان تكون الحالة اما معروضة أو معطلة',
            ]
        );

        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);

        $cat_name = $request->name;
        $cat_parent_id = $request->parent_id;
        $cat_status = $request->status;
        $updated_at = Carbon::now(); // only with db::update query

        $query = DB ::table('categories')
            ->where('id', $id)
            ->update(['name' => $cat_name, 'status' => $cat_status, 'parent_id' => $cat_parent_id, 'updated_at' => $updated_at]);
        if ($query) {
            return response()->json(['status' => 1, "msg" => ""]);
        }
    }

    public function delete($id)
    {
        $category = Category::where('id', $id)->first();
        if ($category) {
            $category->delete();
            return response()->json(['status' => 1, "msg" => trans('category.Category deleted') . " " . "\"$category->name\"" . " " . trans('category.Success')]);
        }
        return response()->json(['status' => 0, "msg" => "حدث خطأ ما"]);
    }


}
