<!--begin::Head-->

<head>
	<base href="">
	<meta charset="utf-8" />
	<title>{{ __('MY STORE') }} - @yield("page_title")</title>
	<meta content="" name="description" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta content="" name="author" />
	<link href="/assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
	<!-- select2 -->

	<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
	<link href="/assets/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- end   -->
	@if (app()->getLocale() == 'en')
	  <link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	  <link href="/assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
	  <link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />	
	  <link href="/fonts/cairo/cairo.css" rel="stylesheet" type="text/css">
	  <link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
	  <link href="/assets/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
	  @elseif(app()->getLocale() == 'ar')
	  <link href="/assets/css/style.bundle.rtl.css" rel="stylesheet" type="text/css" />
	  <link href="/assets/plugins/custom/prismjs/prismjs.bundle.rtl.css" rel="stylesheet" type="text/css" />
	  <link href="/assets/plugins/global/plugins.bundle.rtl.css" rel="stylesheet" type="text/css" />
	  {{-- <link href="{{ asset('backend_assets/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
	  <link href="{{ asset('backend_assets/bootstrap-fileinput/css/fileinput-rtl.css') }}" rel="stylesheet"> --}}
	@endif
	<link href="/assets/plugins/nprogress-master/nprogress.css" rel="stylesheet" type="text/css" />
	<link href="/fonts/cairo/cairo.css" rel="stylesheet" type="text/css">
	<link href="{{ asset('backend_assets/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
	<link href="{{ asset('backend_assets/bootstrap-fileinput/css/fileinput.css') }}" rel="stylesheet">
	<style>
		select {
			text-align-last: center !important;
			padding-bottom: 3px !important;
		}
		.select2-search__field{
			outline: none!important;

		}
		.select2-container--default .select2-search--dropdown .select2-search__field{
			border: 1px solid #5897fb!important;
		}
		.dt-buttons{
			margin-top:5px !important;
		}
	</style>




</head>

@if(app()->getLocale() == 'ar')
<style>
 body {
	
	direction: rtl;
	} 
</style>
@else
<style>
	body {
	
	direction: ltr;
	}
</style>
@endif

<style>

	.btn-group-xs>.btn,
	.btn-xs {
		padding: .25rem .4rem;
		font-size: .875rem;
		line-height: .5;
		border-radius: .2rem;
	}

	.select2 {

		text-align: center;
	}

	.text-muted {

		color: #4d4d96 !important;
	}


	table.bb td,
	th {
		text-align: center;
		font-size: 14px !important;

	}

	#tblAjax_length {
		float: right !important;
		}


</style>

@yield('css')
<!--end::Head-->
