@extends("layouts.superAdmin")
@section('page_title')
تعديل منتج | {{ $product->name }}
@endsection
@section('breadcrumb')

<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
    <li class="breadcrumb-item">
        <a href="/" class="text-muted">الرئيسية</a>
    </li>
    <li class="breadcrumb-item">
        <a href="" class="text-muted"> تعديل منتج | {{ $product->name }} </a>
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
                        <span class="d-block text-muted pt-2 font-size-sm"> تعديل منتج | {{ $product->name }}</span>
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('products.update',$product->id) }}" class="ajaxForm"
                    enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="put">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>اسم المنتج :</label>
                                    <div class="input-icon input-icon-right">
                                        <input name="name" value="{{ $product->name }}" type="text" id="name"
                                            class="form-control" placeholder="" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>سعر المنتج :</label>
                                    <div class="input-icon input-icon-right">
                                        <input name="price" value="{{ $product->price }}" type="text" id="price"
                                            class="form-control" placeholder="" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>وصف المنتج :</label>
                                    <div class="input-icon input-icon-right">
                                        <textarea cols="10" rows="3" name="description" type="text" id="description"
                                            class="form-control">{{ $product->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>غلاف المنتج :</label>
                                    <div class="input-icon input-icon-right">
                                        <input name="image" type="file" id="image" class="form-control"
                                            placeholder="" />
                                    </div>
                                </div>
                                @if (isset($product->image))
                                <img src="{{asset("images/products/cover_image/". $product->image)}}" width="80px"
                                    class="img-rounded">
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label class="">التصنيف</label>
                                <div class="">
                                    {{-- <div class="dropdown bootstrap-select form-control dropup"> --}}
                                    <select name="category_id" id="category_id" class="form-control select2">
                                        <option disabled selected>التصنيف:</option>
                                        @foreach($categories as $category)
                                        <option {{ ($category->id == $product->category_id) ? 'selected' : '' }}
                                            value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" data-select2-id="306">
                                {{-- <div class="col-lg-4 col-md-9 col-sm-12"> --}}
                                <label class="for-tags">الوسوم:</label>
                                <select class="form-control select2" id="tags" name="tags[]" multiple="multiple">
                                    <option disabled>الوسوم:</option>
                                    @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" @foreach($product->tags as $product_tag)
                                        @if($product_tag->id == $tag->id)
                                        selected
                                        @endif
                                        @endforeach>{{ $tag->name }}
                                    </option>
                                    @endforeach
                                </select>
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="row pt-4 pb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="images">صور المنتج</label>
                                    <div class="file-loading">
                                        <input type="file" name="images[]" class="file-input-overview" multiple
                                            id="product-image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-toolbar" style="text-align: left">
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
<script>
    $('.select2').select2();
   
    $(document).ready(function() {
        $(".ajaxForm").ajaxForm({
        success: function(json) {
        $(".ajaxForm :submit").prop("disabled", false);
        if (json.status == 1) {
        // $('.ajaxForm').resetForm();
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

<script>
    $(function () {
         $('#product-image').fileinput({
        theme: "fas",
        maxFileCount: {{ 10 -$product->media->count() }} ,
        // allowedFileTypes: ['image'],
        showCancel: true,
        showRemove: true,
        showUpload: false,
        overwriteInitial: false,
        dropZoneTitle : "{{__('Drop Product Images here')}}",
        initialPreview: [
        @if($product->media->count() > 0)
        @foreach($product->media as $media)
        "{{ asset('images/products/' . $media->image_name) }}",
        @endforeach
        @endif
        ],
        initialPreviewAsData: true,
        initialPreviewFileType: 'image',
        initialPreviewConfig: [
        @if($product->media->count() > 0)
        @foreach($product->media as $media)
        {caption: "{{ $media->image_name }}",
        size: {{ $media->image_size }},
        width: "120px",
        url: "{{ route('products.media.destroy', [$media->id, '_token' => csrf_token()]) }}", key: "{{ $media->id }}"},
        @endforeach
        @endif
        ],
        
        });
        });
</script>
@endsection