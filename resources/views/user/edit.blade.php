<?php
use App\Components\Helper;
?>
@extends(\App\Components\Helper::getLayoutForUser())
@section('content')
    <div class="side-app">
        <div class="page-header page-header-wrap">
            <div class="page-header-left">
                <h1>User: {{$user->username}}</h1>
                <p class="pxp-text-light">Fill below form to continue</p>
            </div>
        </div>

        @include('user.form', compact('user'))
    </div>
@endsection
