<?php
use App\Components\Helper;
?>
@extends(\App\Components\Helper::getLayoutForUser())
@section('content')
    <div class="side-app">
        <div class="page-header page-header-wrap">
            <div class="page-header-left">
                <h1>{{ __('Party Templates') }}</h1>
                {{-- <p class="pxp-text-light">{{__('List of all users registered on website')}}</p> --}}
            </div>
            <div class="page-header-right">
                <a href="{{ url('create-template') . '/' . $party_id }}" class="btn btn-primary">{{ __('Add Template') }}</a>
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
                                    <th>{{ __('Background Image') }}</th>
                                    <th>{{ __('State Name') }}</th>
                                    <th>{{ __('Mapped Filter') }}</th>

                                    <th>{{ __('Action') }}</th>

                                </tr>

                            </thead>

                            <?php
                            $i = 0;
                            ?>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td> <img class="square_image" src="{{ $item->background_image }}"> </td>
                                    <td> {{ $item->states ?? 'N/A' }} </td>
                                    <td> {{ $item->filters ?? 'N/A' }} </td>
                                    <td>
                                        <a href="{{ url('edit-template') . '/' . $item->id }}"
                                            class="btn btn-primary mr-4">Edit</button>
                                            <a href="{{ url('delete-template') . '/' . $item->id }}"
                                                onclick="return confirm('Are you sure you want to delete ?')"
                                                class="btn btn-primary mr-4">Delete</button>
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
