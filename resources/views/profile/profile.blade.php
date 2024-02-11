<?php
use App\Components\Helper;
?>
@extends(\App\Components\Helper::getLayoutForUser())

@section('content')
    <div class="side-app">
        <!-- page-header -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{\App\Components\Helper::dashboardLink()}}">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Change Password') }}</li>
            </ol>
        </div>

        <div class="rounded-16 form-box bg-white -dark-bg-dark-1 shadow-4 h-100">
            <form action="{{ route('updatePassword') }}" method="POST"
                  class="normal-form">
                @csrf
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="form-group required-field text-left @error('old_password') is-invalid @enderror">
                            <label for="old_password">{{ __('Old Password') }}</label>
                            <input id="old_password" type="password"
                                   class="form-control @error('old_password') is-invalid @enderror"
                                   name="old_password" placeholder="{{ __('Enter old password') }}"
                                   value="" autocomplete="off">
                            @error('old_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="form-group required-field text-left @error('password') is-invalid @enderror">
                            <label for="password">{{ __('New Password') }}</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" placeholder="{{ __('Enter new password') }}"
                                   value="" autocomplete="off">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12 col-12">
                        <div class="form-group required-field text-left @error('password_confirmation') is-invalid @enderror">
                            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                            <input id="password_confirmation" type="password"
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   name="password_confirmation" placeholder="{{ __('Enter confirm password') }}"
                                   value="" autocomplete="off">
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 formBtn">
                        <button type="submit" class="btn btn-primary">{{ __('Update Now') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
