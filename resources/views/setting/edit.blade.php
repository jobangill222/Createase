<?php
use App\Components\Helper;
?>
@extends(\App\Components\Helper::getLayoutForUser())
@section('content')
    <div class="side-app">
        <div class="page-header page-header-wrap">
            <div class="page-header-left">
                <h1>{{__('Name')}}: {{$setting->name}}</h1>
                <p class="pxp-text-light">{{__('Fill below form to update')}}</p>
            </div>
            <div class="page-header-right">
                <a href="{{route('setting.index')}}" class="btn btn-primary">{{__('Go Back')}}</a>
            </div>
        </div>

        @include('setting.form', compact('setting'))
    </div>
@endsection
