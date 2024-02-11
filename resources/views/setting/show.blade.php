@extends(\App\Components\Helper::getLayoutForUser())
@section('content')
    <div class="side-app">
        <div class="page-header page-header-wrap">
            <div class="page-header-left">
                <h1>{{$setting->name}}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{\App\Components\Helper::dashboardLink()}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('setting.index')}}">Global Settings</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$setting->name}}</li>
                </ol>
            </div>
            <div class="page-header-right">
                <a href="{{route('setting.index')}}" class="btn btn-primary">{{__('Go Back')}}</a>
            </div>
        </div>

        <div class="media-list">
            <div class="media">
                <div class="media-body">
                    <div>
                        <label>Name</label> <span class="tx-medium">{{$setting->name}}</span>
                    </div>
                    <div>
                        <label>Value</label> <span class="tx-medium">{{$setting->value}}</span>
                    </div>
                </div>
            </div>
            <div class="media">
                <div class="media-body">
                    <div>
                        <label>Created At</label> <span class="tx-medium">@datetime($setting->created_at)</span>
                    </div>
                    <div>
                        <label>Last Updated At</label> <span class="tx-medium">@datetime($setting->updated_at)</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
