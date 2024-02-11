<?php
use App\Components\Helper;
?>
@extends('layouts.guest')

@section('content')
<!-- page-content -->
<div class="page-content">
    <div class="container text-center text-dark">
        <div class="row">
            <div class="col-lg-4 d-block mx-auto">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-md-12">
                        <div class="text-center mb-6 mx-auto">
                            <img style="height: 50px;" src="{{Helper::frontendWithBaseUrl('img/logo.png')}}" class="" alt="">
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h3>{{ __('Login') }}</h3>
                                <p class="text-muted">{{ __('Sign In to your account') }}</p>

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <span class="input-group-addon bg-white"><i class="fa fa-envelope"></i></span>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="{{ __('Username / Email') }}" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="input-group mb-4">
                                        <span class="input-group-addon bg-white"><i class="fa fa-unlock-alt"></i></span>
                                        <input  type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="input-group mb-4">
                                        <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label ml-2" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
                                        </div>
                                        @if (Route::has('register'))
                                        <div class="col-12">
                                            <a href="{{ route('register') }}" class="btn btn-link box-shadow-0 px-0">{{ __('Register') }}</a>
                                        </div>
                                        @endif
                                        @if (Route::has('password.request'))
                                        <div class="col-12">
                                            <a href="{{ route('password.request') }}" class="btn btn-link box-shadow-0 px-0">{{ __('Forgot Your Password?') }}</a>
                                        </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- page-content end -->
@endsection
