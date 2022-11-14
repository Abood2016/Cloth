{{-- {{ dd($category->children->count()) }} --}}
@extends("layouts.superAdmin")
@section('page_title')
تصنيف {{ $category->name }}
@endsection
@section('breadcrumb')

<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
    <li class="breadcrumb-item">
        <a href="/" class="text-muted">الرئيسية</a>
    </li>
    <li class="breadcrumb-item">
        <a href="" class="text-muted"> الأصناف </a>
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
                    <h3 class="card-label">المنتجات لهذا الصنف | {{ $category->name }}</h3>
                </div>
                <div class="card-toolbar">

                    <a href="{{ route('categories') }}" class="btn btn-primary font-weight-bolder" title="رجوع">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                    <path
                                        d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                        fill="#000000" opacity="0.3"></path>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>رجوع </a>

                </div>
            </div>
            <div class="card-body">
               
                <!--begin: Datatable-->
                <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap table-bordered" id="products">
                                    <thead>
                                        <tr>
                                            <th width="1%">#</th>
                                            <th width="3%">المنتج</th>
                                            <th width="3%">السعر</th>
                                            <th width="3%">تاريخ الإضافة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($category->products->count() > 0)
                                            @foreach ($category->products as $product)
                                            <tr>
                                                <td>{{ $product->id}}</td>
                                                <td>{{ $product->name}}</td>
                                                <td>{{ $product->price}}</td>
                                                <td>{{ $product->created_at->format('l d-m-y') }}</td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr class="text-center">
                                                <td colspan="5">
                                                    <p class="mt-2">لا توجد منتجات  </p>
                                                </td>
                                            </tr>
                                        @endif
                                      
                                    <tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end: Datatable-->
            </div>
        </div>

        <div class="card card-custom gutter-b">
            <div class="card-header">

                <div class="card-title">
                    <span class="card-icon">
                        <span class="svg-icon svg-icon-primary svg-icon-2x">
                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Design/Join-1.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path d="M9,10 L9,19 L5,19 L5,10 L5,6 L18,6 L18,10 L9,10 Z" fill="#000000"
                                        transform="translate(11.500000, 12.500000) scale(-1, 1) translate(-11.500000, -12.500000) " />
                                    <circle fill="#000000" opacity="0.3" cx="8" cy="16" r="2" />
                                </g>
                            </svg>
                            <!--end::Svg Icon--></span>
                    </span>
                    <h3 class="card-label">التصنيفات الفرعية | {{ $category->name }}</h3>
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
                                            <th width="3%">الصنف</th>
                                            <th width="3%">تاريخ الإضافة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($category->children->count() > 0)
                                            @foreach ($category->children as $sub_category)
                                            <tr>
                                                <td>{{ $sub_category->id}}</td>
                                                <td>{{ $sub_category->name}}</td>
                                                <td>{{ $sub_category->created_at->format('Y-d-m') }}</td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr class="text-center">
                                                <td colspan="5">
                                                    <p class="mt-2">لا توجد أصناف فرعية </p>
                                                </td>
                                            </tr>
                                        @endif
                                       
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
@section("css")
<style>
    td {
        text-align: center;
    }
</style>
@endsection()
{{-- 
@section('js')
    <script>
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        $('#search').keyup(function(){
            var name = $('#search').val();
            var token = $('meta[name="csrf-token"]').attr('content');
            $.post("/dashboard/categories/category-search", {name: name, _token: token }).done(function(data) {
            // $('#products').replaceWith(data);
        });
        });
    </script>
@endsection --}}