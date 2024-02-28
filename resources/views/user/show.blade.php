@extends(\App\Components\Helper::getLayoutForUser())
@section('content')
    <div class="side-app">
        <div class="page-header page-header-wrap">
            <div class="page-header-left">
                <h1>{{ $user->username }}</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ \App\Components\Helper::dashboardLink() }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $user->username }}</li>
                </ol>
            </div>

            <div class="page-header-right">
                <a href="{{ route('user.index') }}" class="btn btn-primary">{{ __('Go Back') }}</a>
            </div>
        </div>

        <div class="media-list">


            <div class="media">
                <div class="media-body">

                    <div>
                        <label>Profile Image</label>
                        @if ($user->profile_pic)
                            <span class="tx-medium">
                                <img src={{ $user->profile_pic }}>
                                <span>
                                @else
                                    <span class="tx-medium">No Profile Image</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="media">
                <div class="media-body">
                    <div>
                        <label>Name</label> <span class="tx-medium">{{ $user->name ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <div class="media">
                <div class="media-body">
                    <div>
                        <label>Phone Number</label> <span class="tx-medium">{{ $user->phone_number ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <div class="media">
                <div class="media-body">
                    <div>
                        <label>Designtaion</label> <span class="tx-medium">{{ $user->designtaion ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>


            <div class="media">
                <div class="media-body">
                    <div>
                        <label>Created At</label> <span class="tx-medium">@datetime($user->created_at ?? 'N/A')</span>
                    </div>

                </div>
            </div>


            <?php
            // dd($user->userImages);
            ?>
            <div class="media">
                <div class="media-body">
                    <div>
                        <label>Current Party</label> <span
                            class="tx-medium">{{ isset($user->current_party->english_party_name) ? $user->current_party->english_party_name : 'N/A' }}</span>
                    </div>

                </div>
            </div>

            <div class="media">
                <div class="media-body">

                    <div>
                        <label>State</label> <span class="tx-medium">{{ $user->state ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <label>City</label> <span class="tx-medium">{{ $user->city ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <br>
            <br>
            <h3>Photos</h3>

            <div class="table-box">
                <table id="recordsTable" class="table table-hover align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('S. No') }}</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Is Active') }}</th>
                        </tr>

                        <?php
                        $i = 0;
                        ?>

                        @foreach ($user->userImages as $item)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>
                                    <img src={{ $item->image }}>
                                </td>
                                <td>{{ $item->is_active == 1 ? 'true' : 'false' }}</td>
                            </tr>
                        @endforeach
                    </thead>
                </table>
            </div>

        </div>
    </div>
@endsection
