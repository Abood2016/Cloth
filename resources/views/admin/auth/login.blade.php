<!DOCTYPE html>

<html lang="en" direction="rtl" dir="rtl" style="direction: rtl">
<head>
    <link href="http://fonts.cdnfonts.com/css/cairo-2" rel="stylesheet">
    <style>
        #kt_body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
    <meta charset="utf-8" />
    <title>تسجيل الدخول</title>
    <meta name="description" content="Login page example" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="{{ asset('backend_assets/css/pages/login/classic/login-1.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('backend_assets/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend_assets/plugins/custom/prismjs/prismjs.bundle.rtl.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('backend_assets/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('backend_assets/css/themes/layout/header/base/light.rtl.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('backend_assets/css/themes/layout/header/menu/light.rtl.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('backend_assets/css/themes/layout/brand/dark.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend_assets/css/themes/layout/aside/dark.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="backend_assets/media/logos/favicon.ico" />
</head>

<body id="kt_body"
    class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <div class="d-flex flex-column flex-root">
        <div class="login login-1 login-signin-on d-flex flex-row-fluid" id="kt_login">
            <div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid"
                style="background-image: url({{ asset('backend_assets/media/bg/bg-1.jpg')}}) ;">
                <div class="login-form text-center text-white p-7 position-relative overflow-hidden">
                    <div class="d-flex flex-center mb-15">
                        <a href="#">
                            <img src="{{ asset('backend_assets/media/logos/logo-auth.png') }}" class="max-h-85px"
                                alt="" />
                        </a>
                    </div>

                    <div class="login-signin">
                        <div class="mb-20">
                            <h3>سجل الدخول</h3>
                            <p class="opacity-60 font-weight-bold">قم بإدخال بياناتك الصحيحة </p>
                        </div>
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul style="text-align:right">
                                @foreach($errors->all() as $error)
                                <li style="">{{ $error }} </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form class="form" method="post" action="{{ route('admin-login.store') }}" id="kt_login_signin_form">
                            @csrf
                            <div class="form-group">
                                <input
                                    class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8 mb-5"
                                    type="text" placeholder ="الإسم" name="name" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <input
                                    class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8 mb-5"
                                    type="password" placeholder="كلمة المرور" name="password" />
                            </div>

                            <div class="form-group text-center mt-10">
                                <button id="kt_login_signin_submit"
                                    class="btn btn-pill btn-outline-white font-weight-bold opacity-90 px-15 py-3">سجل
                                    الدخول</button>
                            </div>
                        </form>
                    </div>
                    <a href="{{route('password.request')}}" style="color: white">نسيت كلمة المرور ؟</a>
                </div>
            </div>
        </div>
        <!--end::Login-->
        
    </div>


    <script src="{{ asset('backend_assets/js/pages/custom/login/login-general.js') }}"></script>
    <!--end::Page Scripts-->
</body>
<!--end::Body-->

</html>
<!--end::Layout Themes-->
<link rel="shortcut icon" href="{{ asset('backend_assets/media/logos/favicon.ico') }}" />

</html>