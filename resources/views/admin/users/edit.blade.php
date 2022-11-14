<div class="row">
    <div class="col-sm-12">
        <form method="post" action="{{ route('users.update', ['id' => $user->id]) }}" class="ajaxForm">
            {{ csrf_field() }}

            <div class="form-group row">
                <label class="col-3 col-form-label">إسم المستخدم :</label>
                <div class="col-8">
                    <input class="form-control" value="{{ $user->name }}" autofocus style="text-align: center"
                        type="text" id="name" name="name" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-3 col-form-label">اليوزرنيم :</label>
                <div class="col-8">
                    <input class="form-control" value="{{ $user->username }}" autofocus style="text-align: center"
                        type="text" id="username" name="username" autocomplete="off">
                </div>
            </div>
            <input type="hidden" name="_method" value="put" />
            <div class="form-group row">
                <label class="col-3 col-form-label">البريد الإلكتروني :</label>
                <div class="col-8">
                    <input class="form-control" value="{{ $user->email }}" autofocus style="text-align: center"
                        type="text" id="email" name="email" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-3 col-form-label">الباسورد :</label>
                <div class="col-8">
                    <input class="form-control" autofocus style="text-align: center" type="password" id="password"
                        name="password" autocomplete="off">
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
</script>
