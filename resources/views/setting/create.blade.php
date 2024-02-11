@extends(\App\Components\Helper::getLayoutForUser())
@section('content')
    <div class="side-app">
        <div class="page-header page-header-wrap">
            <div class="page-header-left">
                <h1>{{__('Add New Keywords')}}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{\App\Components\Helper::dashboardLink()}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('paragraphKeyword.index')}}">Paragraph Keywords</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add New Paragraph Keywords</li>
                </ol>
            </div>
            <div class="page-header-right">
                <a href="{{route('paragraphKeyword.index')}}" class="btn btn-primary">{{__('Go Back')}}</a>
            </div>
        </div>

        @include('paragraphKeyword.form')
    </div>
@endsection
