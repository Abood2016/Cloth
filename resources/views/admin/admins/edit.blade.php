<div class="row">
    <div class="col-sm-12">
        <form method="post" action="{{ route('admins.update',$admin->id) }}" class="ajaxForm">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="put">
            <div class="form-group row">
                <label class="col-3 col-form-label">الإسم :</label>
                <div class="col-8">
                    <input class="form-control" name="name" autofocus style="text-align: center" type="text" id="name"
                        autocomplete="off" value="{{ $admin->name }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label">الدور :</label>
                <div class="col-8">
                    <select class="form-control select2" id="type" name="type">
                        <option value=""></option>
                        <option value="super-admin" {{$admin->type == "super-admin" ?"selected":""}}>Super-admin</option>
                        <option value="admin"     {{$admin->type == "admin" ?"selected":""}}>Admin</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label">الإيميل :</label>
                <div class="col-8">
                    <input type="text" name="email" class="form-control" autofocus style="text-align: center" value="{{ $admin->email }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label">كلمة المرور :</label>
                <div class="col-8">
                    <input type="password" name="password" class="form-control" autofocus style="text-align: center">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label">الصورة :</label>
                <div class="input-icon input-icon-right">
                    <input name="image" type="file" id="image" class="form-control" placeholder="" />
                        @if (isset($admin->image))
                        <img src="{{asset("images/admins/image/". $admin->image)}}" width="80px"
                        class="img-rounded">
                        @endif
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