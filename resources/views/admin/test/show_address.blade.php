{{-- {{ dd($category->children->count()) }} --}}
@extends("layouts.superAdmin")
@section('page_title')
    address
@endsection
@section('breadcrumb')
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
        <li class="breadcrumb-item">
            <a href="/" class="text-muted">الرئيسية</a>
        </li>
        <li class="breadcrumb-item">
            <a href="" class="text-muted"> المنتجات </a>
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
                        <h3 class="card-label">address</h3>
                    </div>

                </div>

                <div class="card-body">
                    <!--begin: Datatable-->
                    <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="1%">#</th>
                                                <th width="3%">Country</th>
                                                <th width="3%">تاريخ الإضافة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($address as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                
                                                    <td>
                                                        @if (app()->getLocale() == "en" && isset($item->countries_en->name))
                                                        {{ $item->countries_en->name }}
                                                        @elseif(app()->getLocale() == "ar" && isset($item->countries_ar->name))
                                                        {{ $item->countries_ar->name }}
                                                        @endif
                                                    </td>


                                                    {{-- <td>{{ $item->price }}</td> --}}
                                                    <td>{{ $item->created_at->format('l d-m-y') }}</td>
                                                </tr>
                                            @endforeach
                                        <tbody>
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
@section('css')
    <style>
        td {
            text-align: center;
        }

    </style>
@endsection()

@section('js')
    <script>
        $(document).ready(function() {
            $('.show-image').click(function(e) {
                e.preventDefault();
                $('.product_image').click(function() {
                    var image = $(this).attr('src');
                    $('#show_modal').modal('show');
                    $('#image-src').attr('src', image);
                });
            });
        });
    </script>
@endsection
