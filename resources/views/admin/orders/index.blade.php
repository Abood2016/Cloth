@extends("layouts.superAdmin")
@section('page_title')
{{ __('Orders') }}
@endsection
@section('breadcrumb')

<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
    <li class="breadcrumb-item">
        <a href="/" class="text-muted">{{ __('Home') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="" class="text-muted"> {{ __('Orders') }} </a>
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
                    <h3 class="card-label">{{ __('Orders') }}</h3>
                </div>
                <div class="card-toolbar">
                    <a class="btn btn-primary" href="{{route('orders')}}">كل الطلبات</a>
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
                                            <th width="0.5%">{{ __('Order Id') }}</th>
                                            <th width="3%">{{ __('Product') }}</th>
                                            <th width="3%">{{ __('User') }}</th>
                                            <th width="3%">{{ __('Status') }}</th>
                                            <th width="0.5%">{{ __('quantity') }}</th>
                                            <th width="3%">{{ __('Price') }}</th>
                                            <th width="3%">{{ __('Created Date') }}</th>
                                            <th width="3%">{{ __('Action') }}</th>
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
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,

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
                     data: 'order_id',
                     name: 'order_id'
                 },
                {
                    data: 'product_name',
                    name: 'product_name'
                },
                {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'status',
                    name: 'status'
                },

                {
                data: 'quantity',
                name: 'quantity'
                },

                {
                data: 'price',
                name: 'price'
                },

                {
                    data: 'Date',
                    name: 'Date'
                },

               {data: 'actions', name: 'actions',orderable:false,serachable:false,sClass:'text-center'},
            ],
            ajax: {
                type: "POST",
                contentType: "application/json",
                url: '/dashboard/orders/AjaxDT',
                data: function(d) {
                    d._token = "{{csrf_token()}}";
                  return JSON.stringify(d);
            },
            },
            fnDrawCallback: function() {}
        });
    }
    
    </script>

    @endsection()