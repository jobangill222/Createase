<?php
use App\Components\Helper;
?>
@extends(\App\Components\Helper::getLayoutForUser())
@section('content')
    <div class="side-app">
        <div class="page-header page-header-wrap">
            <div class="page-header-left">
                <h1>{{__('All Users')}}</h1>
                <p class="pxp-text-light">{{__('List of all users registered on website')}}</p>
            </div>
            {{-- <div class="page-header-right">
                <a href="{{route('user.create')}}" class="btn btn-primary">{{__('Add New')}}</a>
            </div> --}}
        </div>

        <div class="table-wrapper">
            <div class="table-filters-ghost" style="display: none;">
                <div class="p-b-10 mt-3 searchFiltersContainer">
                    <div class="card-body p-t-10 searchFilters">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group text-left">
                                    <label for="role">{{ __('Search') }}</label>
                                    <input type="text" name="q" value="" class="form-control filterField" placeholder="Enter Search">
                                </div>
                            </div>
                            {{-- <div class="col-md-6 col-12">
                                <div class="form-group text-left">
                                    <label for="status">{{ __('Status') }}</label>
                                    <select name="status" id="status" class="form-control filterField">
                                        <option value="">Select Status</option>
                                        @foreach (\App\Constants\UserConstants::STATUS_PROPERTIES as $userStatus => $userStatusData)
                                            <option value="{{$userStatus}}">{{$userStatusData['text']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-box">
                <table id="recordsTable" class="table table-hover align-middle" style="width:100%">
                    <thead>
                    <tr>
                        {{-- <th>{{__('Username')}}</th> --}}
                        <th>{{__('Phone Number')}}</th>
                        {{-- <th>{{__('Email')}}</th> --}}
                        <th>{{__('Status')}}</th>
                        <th>{{__('Email Verified')}}</th>
                        <th>{{__('Created On')}}</th>
                        {{-- <th>{{__('Updated On')}}</th> --}}
                        {{-- <th>{{__('Actions')}}</th> --}}
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('pageJs')

    <script>
        $(document).ready(function () {
            let recordsTable = $('#recordsTable');
            let mainTableWrapper = recordsTable.closest(".table-wrapper");
            let filters = mainTableWrapper.find(".table-filters-ghost");
            let dataTableOptions = {!! json_encode(\App\Common\ContentHelper::getDataTableOptions()) !!};
            let recordsTableObj = recordsTable.DataTable({
                ...dataTableOptions,
                processing: false,
                order: [[4, "desc"]],
                ajax: {
                    url: "{{ route('user.dataTable') }}",
                    data: function (data) {
                        data['search_query'] = {};
                        mainTableWrapper.find(".filterField").each(function () {
                            let obj = $(this);
                            data['search_query'][obj.attr("name")] = obj.val();
                        });
                    },
                    dataSrc: function (json) {
                        let data = json.stats;
                        return json.data;
                    }
                },
                columns: [
                    // {data: 'username', name: 'username'},
                    {data: 'phonenumber', name: 'phonenumber'},
                    // {data: 'email', name: 'email'},
                    {data: 'status', name: 'status'},
                    {data: 'emailVerified', name: 'email_verified_at'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at', visible: false},
                    // {
                    //     data: 'actions',
                    //     name: 'actions',
                    //     orderable: true,
                    //     searchable: true
                    // },
                ]
            });
            mainTableWrapper.find(".tableFilters").html(filters.html());
            filters.remove();
            $(document).on('keyup change', '.filterField', function () {
                recordsTableObj.draw();
            });
        });
    </script>

@endsection
