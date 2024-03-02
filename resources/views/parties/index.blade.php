<?php
use App\Components\Helper;
?>
@extends(\App\Components\Helper::getLayoutForUser())
@section('content')
    <div class="side-app">

        <div class="page-header page-header-wrap">
            <div class="page-header-left">
                <h1>{{ __('All Parties') }}</h1>
                {{-- <p class="pxp-text-light">{{__('List of all users registered on website')}}</p> --}}
            </div>
            <div class="page-header-right">
                <a href="{{ route('parties.create') }}" class="btn btn-primary">{{ __('Add New Party') }}</a>
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
                    <div class="table-box table-responsive">
                        <table id="recordsTable" class="table table-hover align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{ __('S.No') }}</th>
                                    <th>{{ __('Party Image') }}</th>
                                    <th>{{ __('English Party Name') }}</th>
                                    <th>{{ __('English Party Description') }}</th>
                                    <th>{{ __('Hindi Party Name') }}</th>
                                    <th>{{ __('Hindi Party Description') }}</th>

                                    <th>{{ __('Centre Image 1') }}</th>
                                    <th>{{ __('Centre Image 2') }}</th>

                                    <th>{{ __('Action') }}</th>
                                </tr>

                            </thead>

                            <?php
                            $i = 0;
                            ?>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td> <img src={{ $item->party_image }}> </td>
                                    <td>{{ $item->english_party_name }}</td>
                                    <td>{{ $item->english_party_description }}</td>
                                    <td>{{ $item->hindi_party_name }}</td>
                                    <td>{{ $item->hindi_party_description }}</td>

                                    <td>
                                        @if ($item->centre_image_first)
                                            <img src={{ $item->centre_image_first }}>
                                        @else
                                            {{ 'No Image' }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->centre_image_second)
                                            <img src={{ $item->centre_image_second }}>
                                        @else
                                            {{ 'No Image' }}
                                        @endif

                                    </td>

                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ url('parties/edit') . '/' . $item->id }}"
                                                class="btn btn-primary mr-4">Edit Party</a>
                                            <a href="{{ url('create-template') . '/' . $item->id }}"
                                                class="btn btn-primary mr-4">Add Template</a>
                                            <a href="{{ url('view-template') . '/' . $item->id }}"
                                                class="btn btn-primary mr-4">View Template</a>
                                            <a href="{{ url('parties/delete') . '/' . $item->id }}"
                                                onclick="return confirm('Are you sure you want to delete ?')"
                                                class="btn btn-primary mr-4">Delete Party</a>
                                        </div>
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
