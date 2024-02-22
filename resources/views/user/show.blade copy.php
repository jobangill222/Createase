@extends(\App\Components\Helper::getLayoutForUser())
@section('content')
    <div class="side-app">
        <div class="page-header page-header-wrap">
            <div class="page-header-left">
                <h1>{{$user->username}}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{\App\Components\Helper::dashboardLink()}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('user.index')}}">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$user->username}}</li>
                </ol>
            </div>
            <div class="page-header-right">
                <a href="{{route('user.index')}}" class="btn btn-primary">{{__('Go Back')}}</a>
            </div>
        </div>

        <div class="media-list">
            <div class="media">
                <div class="media-body">
                    <div>
                        <label>Name</label> <span class="tx-medium">{{$user->name}}</span>
                    </div>
                </div>
            </div>
            <div class="media">
                <div class="media-body">
                    <div>
                        <label>Username</label> <span class="tx-medium">{{$user->username}}</span>
                    </div>
                    <div>
                        <label>Email</label> <span class="tx-medium">{{$user->email}}</span>
                    </div>
                </div>
            </div>
            <div class="media">
                <div class="media-body">
                    <div>
                        <label>Status</label> <span class="tx-medium">{!! $user->statusHtml() !!}</span>
                    </div>
                    <div>
                        <label>Role</label> <span class="tx-medium">{{$user->role->name}}</span>
                    </div>
                </div>
            </div>
            <div class="media">
                <div class="media-body">
                    <div>
                        <label>Email Verified At</label> <span class="tx-medium">@datetime($user->email_verified_at)</span>
                    </div>
                    <div>
                        <label>Created At</label> <span class="tx-medium">@datetime($user->created_at)</span>
                    </div>
                    <div>
                        <label>Last Updated At</label> <span class="tx-medium">@datetime($user->updated_at)</span>
                    </div>
                </div>
            </div>

            <div class="media">
                <div class="media-body">
                    <div>
                        <label>Country</label> <span class="tx-medium">{{$user->country}}</span>
                    </div>
                    <div>
                        <label>State</label> <span class="tx-medium">{{$user->state}}</span>
                    </div>
                    <div>
                        <label>City</label> <span class="tx-medium">{{$user->city}}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
