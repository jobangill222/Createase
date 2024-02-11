@extends(\App\Components\Helper::getLayoutForUser())
@section('content')
    <div class="side-app">
        <div class="page-header page-header-wrap">
            <div class="page-header-left">
                <h1>{{__('Add New User')}}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{\App\Components\Helper::dashboardLink()}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('user.index')}}">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add New User</li>
                </ol>
            </div>
            <div class="page-header-right">
                <a href="{{route('user.index')}}" class="btn btn-primary">{{__('Go Back')}}</a>
            </div>
        </div>

        @include('user.form')
    </div>
@endsection
