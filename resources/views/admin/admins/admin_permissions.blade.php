@extends("layouts.superAdmin")
@section('page_title')
{{ __(" '\"$admin->name\"  Permissions") }}
@endsection
@section('breadcrumb')

<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
    <li class="breadcrumb-item">
        <a href="/" class="text-muted">{{ __('Home') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('permissions') }}" class="text-muted"> {{ __(" '\"$admin->name\"  Permissions") }}

 </a>
    </li>
</ul>
@endsection

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="card card-custom gutter-b">
            <div class="card-header">

                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-supermarket text-primary"></i>
                    </span>
                    <h3 class="card-label">{{ __(" '\"$admin->name\"  Permissions") }}
                    </h3>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-9 row mt-4 ">
                    <div class="col-sm-12 row d-flex flex-row" style="margin-right: 0.01em">
                        <form method="post"  action="{{ route('admins.set_permission',$admin->id) }}" class="col-sm-12 row mt-2 ajaxForm" id="">
                            @csrf
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="put">
                           <label class="col-md-6 ml-6">Edit Permission:</label><br>
                            <p class="col-sm-12 d-flex flex-row">
                                <span class="ml-6 mr-3 mt-1"></span>
                                <select class="form-control select2" id="name" name="name[]" multiple="multiple">
                                    <option disabled>Permissions:</option>
                                    @foreach($permissions as $permission)
                                    <option value="{{ $permission->id }}" @foreach($admin->permissions as $admin_permission)
                                        @if($admin_permission->id == $permission->id)
                                        selected
                                        @endif
                                        @endforeach>{{ $permission->name }}
                                    </option>
                                    @endforeach
                                </select>
                                    <div class="d-flex flex-row col-md-6">
                                        <button type="submit" data-refresh="true" class="btn btn-sm btn-success btn-submit ml-9">Update Permission</button>
                                    </div>
                            </p>
                           
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!--begin: Datatable-->
                <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap table-bordered" id="tblAjax">
                                    <thead>
                                        <tr>
                                            <th width="3%">{{ __('Admin') }}</th>
                                            <th width="3%">{{ __('Permission') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end: Datatable-->
            </div>
        </div>
    </div>
         <input type="hidden" name="id" value="{{ $admin->id }}">
    </div>

    @endsection
    @section("css")

    @include('include.dataTable_css')

    @endsection()

    @section('js')

    @include('include.dataTable_scripts')
    <script>
        var oTable;
    $(function() {
        BindDataTable();
    });

    var id= $("input[name=id]").val();
    //هذه تختلف حسب الصفحة
    function BindDataTable() {
        oTable = $('#tblAjax').DataTable({
            
            "language": {
            emptyTable:"{{ __('No Data Found') }}",
            "sProcessing": "{{ __('Downloading') }}...",
            "sLengthMenu": "{{ __('Show') }} _MENU_ {{ __('Entries') }}",
            "sZeroRecords": "{{ __('No Data') }}",
            "sInfo": "{{ __('Show') }} _START_ {{ __('To') }} _END_ ",
            "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
            "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
            "sInfoPostFix": "",
            "sSearch": "بحث:",
            'selectedRow': "{{ __('all Selected') }}",
            "sUrl": "",
            "oPaginate": {
            "sFirst": "{{ __('First') }}",
            "sPrevious": "{{ __('Previous') }}",
            "sNext": "{{ __('Next') }}",
            "sLast": "{{ __('Last') }}",
            }
            },
            lengthMenu: [5, 10, 25, 50 , 100],
            pageLength: 50,

           "paging": true,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            serverSide: true,
            "bDestroy": true,
            "bSort": true,
            visible: true,
            "iDisplayLength": 10,
            "sPaginationType": "full_numbers",
            "bAutoWidth":false,
            "bStateSave": true,
            columnDefs: [ {
            // targets: 0,
            visible: true
            } ],
            
           dom: 'lBfrtip',
                buttons: [

                { extend: 'print',
                    text: "{{ __('Print') }}",
                    customize: function (win) {
                        @if (app()->getLocale() == 'en')
                         $(win.document.body).css('direction', 'ltr');
                        @elseif (app()->getLocale() == 'ar')
                         $(win.document.body).css('direction', 'rtl');
                        @endif
                    },
                    exportOptions: {
                    columns: ':visible' }},

                   { extend: 'colvis',
                    text: "{{ __('Select Columns') }}"
                    },
                   
                   {extend: 'excelHtml5',
                    text: "{{ __('Excel') }}",
                    exportOptions: {
                    columns: ':visible', }},
                    ],

            columnDefs: [{
                targets: 0,
                visible: true
            }],

            "order": [
                [0, "asc"]
            ],
            serverSide: true,
            columns: [

                {
                    data: 'admin_name',
                    name: 'admin_name'
                },
                {
                    data: 'permission_name',
                    name: 'permission_name'
                },

            ],
            
            ajax: {
                
                type: "POST",
                contentType: "application/json",
                url: '/dashboard/admins/permissions_AjaxDT/' + id,
                data: function(d) {
                    d._token = "{{csrf_token()}}";
                  return JSON.stringify(d);
            },
            },
            fnDrawCallback: function() {}
        });
    }
    
    </script>

    <script>
   
    $(document).ready(function() {
        $(".ajaxForm").ajaxForm({
        success: function(json) {
        $(".ajaxForm :submit").prop("disabled", false);
        if (json.status == 1) {
        // $('.ajaxForm').resetForm();
        BindDataTable();
        $('.select2').select2();
        ShowMessage(json.msg, "success", "متجري");
        if (json.redirect != null)
        setTimeout(function() {
         window.location = json.redirect
        }, 800);
        
        if ($(".ajaxForm :submit").data("refresh") == true) {
        // $('.ajaxForm').resetForm();
        }
        } else {
        ShowMessage(json.msg, "error", "متجري");
        }
        if (json.redirect != null)
        setTimeout(function() {
        window.location = json.redirect
        }, 800);
        
        },
        beforeSubmit: function() {
        $(".ajaxForm :submit").prop("disabled", true);
        },
        error: function(json) {
        $(".ajaxForm :submit").prop("disabled", false);
        errorsHtml = "<ul>";
            $.each(json.responseJSON, function(key, value) {
            console.log(value);
            errorsHtml += '<li>' + value[0] + '</li>';
            });
            errorsHtml += "</ul>";
        ShowMessage(errorsHtml, "error", "متجري");
        }
        }); 
       
    });

</script>
    @endsection()