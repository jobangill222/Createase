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
                                    <h3>{{ __('Register') }}</h3>
                                    <p class="text-muted">{{ __('Create an account') }}</p>

                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <span class="input-group-addon bg-white"><i class="fa fa-user"></i></span>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Name') }}" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>

                                        <div class="input-group mb-3">
                                            <span class="input-group-addon bg-white"><i class="fa fa-envelope"></i></span>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('Email Address') }}" name="email" value="{{ old('email') }}" required autocomplete="email">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>

                                        <div class="input-group mb-4">
                                            <span class="input-group-addon bg-white"><i class="fa fa-unlock-alt"></i></span>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Password') }}">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>

                                        <div class="input-group mb-4">
                                            <span class="input-group-addon bg-white"><i class="fa fa-lock"></i></span>
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="confirm-password" placeholder="{{ __('Confirm Password') }}">

                                            @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary btn-block">{{ __('Register') }}</button>
                                            </div>
                                            @if (Route::has('login'))
                                                <div class="col-12">
                                                    <a href="{{ route('login') }}" class="btn btn-link box-shadow-0 px-0">{{ __('Login') }}</a>
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
