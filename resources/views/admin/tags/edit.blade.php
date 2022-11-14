<div class="row">
    <div class="col-sm-12">
        <form method="post" action="{{ route('tags.update',['id' => $tag->id]) }}" class="ajaxForm">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="put">
            <div class="form-group row">
                <label class="col-3 col-form-label">التصنيف :</label>
                <div class="col-8">
                    <input class="form-control" name="name" value="{{ $tag->name }}" autofocus
                        style="text-align: center" type="text" id="name" autocomplete="off">
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