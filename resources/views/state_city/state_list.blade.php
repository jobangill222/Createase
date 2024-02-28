<?php
use App\Components\Helper;
?>
@extends(\App\Components\Helper::getLayoutForUser())
@section('content')
    <div class="side-app">
        <div class="page-header page-header-wrap">
            <div class="page-header-left">
                <h1>{{ __('All States') }}</h1>
                {{-- <p class="pxp-text-light">{{__('List of all users registered on website')}}</p> --}}
            </div>
            <div class="page-header-right">
                <a href="{{ route('state.create') }}" class="btn btn-primary">{{ __('Add New State') }}</a>
            </div>
        </div>


        <div class="card">
            <div class="card-body">

                <div class="table-wrapper">
                    <div class="table-filters-ghost" style="display: none;">
                        <div class="p-b-10 mt-3 searchFiltersContainer">
                            <div class="card-body p-t-10 searchFilters">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group text-left">
                                            <label for="role">{{ __('Search') }}</label>
                                            <input type="text" name="q" value=""
                                                class="form-control filterField" placeholder="Enter Search">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group text-left">
                                            <label for="status">{{ __('Status') }}</label>
                                            <select name="status" id="status" class="form-control filterField">
                                                <option value="">Select Status</option>
                                                @foreach (\App\Constants\UserConstants::STATUS_PROPERTIES as $userStatus => $userStatusData)
                                                    <option value="{{ $userStatus }}">{{ $userStatusData['text'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-box">
                        <table id="recordsTable" class="table table-hover align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{ __('S.No') }}</th>
                                    <th>{{ __('English Name') }}</th>
                                    <th>{{ __('Hindi Name') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>

                            </thead>

                            <?php
                            $i = 0;
                            ?>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $item->english_name }}</td>
                                    <td>{{ $item->hindi_name }}</td>
                                    <td>
                                        <a href="{{ url('state/edit') . '/' . $item->id }}"
                                            class="btn btn-primary mr-4">Edit
                                            State</a>
                                        <a href="{{ url('state/delete') . '/' . $item->id }}"
                                            class="btn btn-primary mr-4">Delete State</a>

                                        <a href="{{ url('add-city') . '/' . $item->id }}" class="btn btn-primary mr-4">Add
                                            City</a>
                                        <a href="{{ url('city-list') . '/' . $item->id }}" class="btn btn-primary">View
                                            City</a>
                                        <a href="{{ url('link-state-parties') . '/' . $item->id }}"
                                            class="btn btn-primary">Link
                                            Parties</a>
                                    </td>

                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
@section('pageJs')
@endsection
