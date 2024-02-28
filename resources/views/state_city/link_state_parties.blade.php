<?php
use App\Components\Helper;
?>
@extends(\App\Components\Helper::getLayoutForUser())
@section('content')
    <div class="side-app">
        <div class="page-header page-header-wrap">
            <div class="page-header-left">
                <h1>{{ __('Link Parties') }}</h1>
                {{-- <p class="pxp-text-light">{{__('List of all users registered on website')}}</p> --}}
            </div>
            {{-- <div class="page-header-right">
                <a href="{{ route('state.create') }}" class="btn btn-primary">{{ __('Add New State') }}</a>
            </div> --}}
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

                                </div>
                            </div>
                        </div>
                    </div>

                    <form id="validate-from" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="form-group required-field text-left @error('name') is-invalid @enderror">
                                    <label for="party_id">{{ __('Parties') }}</label>
                                    <select class="form-control" name="party_id">
                                        <option value="">Select Party</option>
                                        @foreach ($all_parties as $row)
                                            <option value="{{ $row->id }}">{{ $row->english_party_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('party_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="form-group required-field text-left @error('name') is-invalid @enderror">
                                    <label for="name">{{ __('State Image 1') }}</label>

                                    <div class="col-md-6">
                                        <input id="image" type="file"
                                            class="form-control-file @error('state_image_first') is-invalid @enderror"
                                            name="state_image_first" accept="image/*"
                                            onchange="previewStateFirstImage(event)">
                                        @error('state_image_first')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        <img id="imagePreviewStateFirst" src="#" alt="Image Preview"
                                            style="display: none; max-width: 100%; margin-top: 10px;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-6">
                                <div class="form-group required-field text-left @error('name') is-invalid @enderror">
                                    <label for="name">{{ __('State Image 2') }}</label>

                                    <div class="col-md-6">
                                        <input id="image" type="file"
                                            class="form-control-file @error('state_image_second') is-invalid @enderror"
                                            name="state_image_second" accept="image/*"
                                            onchange="previewStateSecondImage(event)">
                                        @error('state_image_second')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        <img id="imagePreviewStateSecond" src="#" alt="Image Preview"
                                            style="display: none; max-width: 100%; margin-top: 10px;">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row mb-4">
                            <div class="col-xs-12 col-sm-12 col-md-12 formBtn">
                                {{-- <button type="submit" class="btn btn-primary">{{ __('Add') }}</button> --}}
                                <input type="submit" value="Link" class="btn btn-primary">
                            </div>
                        </div>



                    </form>



                    <br>
                    <br>

                    <h4>Linked Parties</h4>

                    <div class="table-box">
                        <table id="recordsTable" class="table table-hover align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{ __('S.No') }}</th>
                                    <th>{{ __('English Party Name') }}</th>
                                    <th>{{ __('Hindi Party Name') }}</th>

                                    <th>{{ __('State Leader 1') }}</th>
                                    <th>{{ __('State Leader 2') }}</th>

                                    <th>{{ __('Action') }}</th>
                                </tr>

                            </thead>

                            <?php
                            $i = 0;
                            ?>
                            @foreach ($already_linked_parties as $item)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $item->partyDetails->english_party_name }}</td>
                                    <td>{{ $item->partyDetails->hindi_party_name }}</td>

                                    <td>
                                        <img src="{{ $item->state_leader_first }}">
                                    </td>
                                    <td>
                                        <img src="{{ $item->state_leader_second }}">
                                    </td>

                                    <td>
                                        {{-- <a href="{{ url('add-city') . '/' . $item->id }}" class="btn btn-primary mr-4">Link
                                            Party</a> --}}
                                        <a href="{{ url('un-link-state-party') . '/' . $item->id }}"
                                            class="btn btn-primary">Un-Link
                                            Party</a>
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
    <script>
        function previewStateFirstImage(event) {
            var image = document.getElementById('imagePreviewStateFirst');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.style.display = 'block';
        }

        function previewStateSecondImage(event) {
            var image = document.getElementById('imagePreviewStateSecond');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.style.display = 'block';
        }
    </script>
@endsection
