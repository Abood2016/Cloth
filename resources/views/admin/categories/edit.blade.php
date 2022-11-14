<div class="row">
    <div class="col-sm-12">
        <form method="post" action="{{ route('categories.update',['id' => $category->id]) }}" class="ajaxForm">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="put">
            <div class="form-group row">
                <label class="col-3 col-form-label">التصنيف :</label>
                <div class="col-8">
                    <input class="form-control" name="name" value="{{ $category->name }}" autofocus style="text-align: center" type="text" id="name"
                        autocomplete="off">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label">التصنيف الأب :</label>
                <div class="col-8">
                    <select class="form-control select2" id="parent_id" name="parent_id">
                        <option value="">لا يوجد أب</option>
                        @foreach (App\Models\Category::all() as $cat)
                        <option {{ ($cat->id == $category->parent_id) ? 'selected' : '' }}  value="{{ $cat->id }}">{{ $cat->name }}</option>
                         @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label">الحالة :</label>
                <div class="col-8">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status-published"
                            value="published" {{ $category->status == 'published' ? 'checked' : '' }} >
                        <label class="form-check-label" for="status-published">
                            عرض في الصفحة
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status"
                         id="status-draft" value="draft" {{ $category->status == 'draft' ? 'checked' : '' }} >
                        <label class="form-check-label" for="status-draft">
                            تعطيل
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-sm-8 offset-sm-4">
                <button type="submit" data-refresh="true" class="btn green btn-primary">حفظ</button>
                <a class="btn btn-default " data-dismiss="modal">الغاء الأمر</a>
            </div>
    </div>

    </form>
</div>


<script>
    PageLoadMethods();

//     $('#Popup .select2').each(function() {  
//    var $p = $(this).parent(); 
//    $(this).select2({  
//      dropdownParent: $p,
//         theme: "bootstrap"
//    });  
// });
   $('.select2').select2();
</script>