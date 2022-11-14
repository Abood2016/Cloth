@extends("layouts.superAdmin")
@section('page_title')
منتج جديد
@endsection
@section('css')
@endsection
@section('breadcrumb')

<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
    <li class="breadcrumb-item">
        <a href="/" class="text-muted">الرئيسية</a>
    </li>
    <li class="breadcrumb-item">
        <a href="" class="text-muted"> منتج جديد </a>
    </li>
</ul>
@endsection


@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">اضافة منتج
                        <span class="d-block text-muted pt-2 font-size-sm">عرض جميع &amp; اضافة منتج</span>
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('test.store') }}" >
                    {{csrf_field()}}
                    <div class="card-body">
                        <div class="row">
                            @if (app()->getLocale() == "ar")
                              @include('admin.test.address._countries_cities')
                              @else
                              @include('admin.test.address._countries_en_cities_en')
                            @endif
                        </div>
                      
                        <div class="card-toolbar" style="text-align: center">
                            <button type="submit" data-refresh="true" class="btn green btn-primary">حفظ</button> <button
                                type="reset" class="btn btn-secondary">إلغاء</button>
                        </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@if (app()->getLocale() == "ar")
<script>
    $('.select2').select2();
            $('#selectCountryCheckout').change(function() {
                var country_id = $(this).val();
                $.ajax({
                    url: "/dashboard/test/cities/" + country_id,
                    type: "get",
                    // {{-- data: {country_idountry_id:country_id, _token: '{{csrf_token()}}'}, --}}
                    success: function(data) {
                        $('#selectCityCheckout').html(data);
                    }
                });
            });
</script>

@else
<script>
    $('.select2').select2();
            $('#selectCountry_en_Checkout').change(function() {
                var country_en_id = $(this).val();
                $.ajax({
                    url: "/dashboard/test/cities_en/" + country_en_id,
                    type: "get",
                    // {{-- data: {country_idountry_id:country_id, _token: '{{csrf_token()}}'}, --}}
                    success: function(data) {
                        $('#selectCity_en_Checkout').html(data);
                    }
                });
            });
</script>
@endif


@endsection