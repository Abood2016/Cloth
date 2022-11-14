@extends('layouts.superAdmin')

@section('content')
<div class="panel panel-danger">
    <div class="panel-heading">{{ __('Sorry,You dont have permission on this link') }}</div>

    <div class="panel-body">
        {{ __('dear User , Please Call System Adminstrator ')}} ...
    </div>
</div>
@endsection


@section("title")
{{ __('No Permission') }}
@endsection()