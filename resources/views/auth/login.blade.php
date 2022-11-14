@extends('layouts.front')
@section('bar_title')
Login
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center" style="padding-top: 30px;padding-bottom: 30px">
        <div class="col-md-8">
            <div class="card ">
                {{-- <h4 class="card-header text-center ">{{ __('Register') }}</h4> --}}
                <div class="card-body justify-content-center">
                    @if (session()->has('alert.erorr'))
                    <div class="alert alert-danger">
                        {{ session('alert.erorr') }}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username')
                                }}</label>

                            <div class="col-md-6">
                                <input id="text" type="username"
                                    class="form-control @error('username') is-invalid @enderror" name="username"
                                    required autocomplete="username">

                                @error('username')
                                <small class="invalid-feedback" style="color: red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password')
                                }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">

                                @error('password')
                                <small class="invalid-feedback" style="color: red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                        </div>
                        <div class="pb-4" style="padding-bottom: 5px">
                            <a href="{{ route('social.redirect',['facebook']) }}" class="btn btn-primary">Login by Facebook</a>
                        </div>

                        <div class="pb-4" style="padding-bottom: 5px">
                            <a href="{{ route('social.redirect',['google']) }}" class="btn btn-danger">Login by Google</a>
                        </div>

                         <div class="pb-4" style="padding-bottom: 5px">
                            <a href="{{ route('social.redirect',['github']) }}" class="btn btn-success">Login by Github</a>
                        </div>
                        
                        <div class="form-group row mb-0 mt-2">
                            <div class="col-md-6 offset-md-4 ">
                                <button type="submit" class="btn btn-success text-center">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection