{{-- {{ dd($category->children->count()) }} --}}
@extends("layouts.superAdmin")
@section('page_title')
منتج {{ $product->name }}
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
                    <h3 class="card-label">منتج | {{ $product->name }}</h3>
                </div>
                <div class="card-toolbar">

                    <a href="{{ route('products') }}" class="btn btn-primary font-weight-bolder" title="رجوع">
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
                                <table class="table table-hover text-nowrap table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="1%">#</th>
                                            <th width="3%">المنتج</th>
                                            <th width="3%">السعر</th>
                                            <th width="3%">الصنف</th>
                                            <th width="3%">وصف</th>
                                            <th width="3%">صورة الغلاف</th>
                                            <th width="3%">تاريخ الإضافة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($product->count() > 0)
                                        <tr>
                                            <td>{{ $product->id}}</td>
                                            <td>{{ $product->name}}</td>
                                            <td>{{ $product->price}}</td>
                                            <td><span class="badge badge-primary">{{ $product->category->name}}</span>
                                            </td>
                                            <td>{!! $product->description !!}</td>
                                            <td>
                                                <img src="{{ asset('images/products/cover_image/' . $product->image) }}"
                                                    style="border-radius: 10px;" width="40" class="img-rounded">
                                            </td>
                                            <td>{{ $product->created_at->format('l d-m-y') }}</td>
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
                        <i class="flaticon2-supermarket text-primary"></i>
                    </span>
                    <h3 class="card-label">صور المنتج | {{ $product->name }}</h3>
                </div>
            </div>

            <div class="card-body">
                <!--begin: Datatable-->
                <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-body">
                                @if ($product->media->count() > 0)
                                @foreach ($product->media as $item)
                                <a href="#" class="show-image">
                                    <img src="{{ asset('images/products/' . $item->image_name) }}"
                                        style="border-radius: 13px;" width="150" class="img-rounded p-2 product_image"
                                        id="">
                                </a>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!--end: Datatable-->
            </div>
        </div>


    </div>
</div>

<div class="modal fade" id="show_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">الصورة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body " style=" text-align: center!important;font-size: 1.3em!important;">
                <img style="border-radius: 13px;" width="200" class="img-rounded p-2" id="image-src">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
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

@section('js')
<script>
    $(document).ready(function() {
            $('.show-image').click(function(e) {
                e.preventDefault();
            $('.product_image').click(function() {
                  var image = $(this).attr('src');
                  $('#show_modal').modal('show');
                  $('#image-src').attr('src',image);
            });
        });});
</script>
@endsection