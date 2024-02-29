<?php
use App\Components\Helper;
?>
@extends(\App\Components\Helper::getLayoutForUser())
@section('content')
    <div class="side-app">
        <div class="page-header page-header-wrap">
            <div class="page-header-left">
                <h1>{{ __('Add Parties') }}</h1>
                {{-- <p class="pxp-text-light">{{__('List of all users registered on website')}}</p> --}}
            </div>

        </div>

        <div class="table-wrapper">
            <div class="table-filters-ghost" style="display: none;">
                <div class="p-b-10 mt-3 searchFiltersContainer">
                    <div class="card-body p-t-10 searchFilters">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group text-left">
                                    <label for="role">{{ __('Search') }}</label>
                                    <input type="text" name="q" value="" class="form-control filterField"
                                        placeholder="Enter Search">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group text-left">
                                    <label for="status">{{ __('Status') }}</label>
                                    <select name="status" id="status" class="form-control filterField">
                                        <option value="">Select Status</option>
                                        @foreach (\App\Constants\UserConstants::STATUS_PROPERTIES as $userStatus => $userStatusData)
                                            <option value="{{ $userStatus }}">{{ $userStatusData['text'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <form id="validate-from" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}


                <div class="card">
                    <div class="card-body">


                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group required-field text-left @error('name') is-invalid @enderror">
                                    <label for="name">{{ __('Party Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="image" type="file"
                                            class="form-control-file @error('party_image') is-invalid @enderror"
                                            name="party_image" accept="image/*" onchange="previewImage(event)">
                                        @error('party_image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        {{-- <img id="imagePreview" src="#" alt="Image Preview" class='square_image'
                                            style="display: none; max-width: 100%; margin-top: 10px;"> --}}
                                        <img id="imagePreview" src="{{ $party_details->party_image }}" alt="Image Preview"
                                            class='square_image'
                                            style="max-width: 100%; margin-top: 10px; {{ isset($party_details->party_image) ? 'display: block;' : 'display: none;' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="form-group required-field text-left @error('name') is-invalid @enderror">
                                    <label for="name">{{ __('Party Name In English') }}</label>
                                    <input id="english_party_name" type="text"
                                        class="form-control @error('english_party_name') is-invalid @enderror"
                                        name="english_party_name" placeholder="{{ __('Enter Party Name In English') }}"
                                        value="{{ $party_details->english_party_name ?? 'N/A/' }}">
                                    @error('english_party_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 col-6">
                                <div class="form-group required-field text-left @error('name') is-invalid @enderror">
                                    <label for="name">{{ __('Party Name In Hindi') }}</label>
                                    <input id="party_name" type="text"
                                        class="form-control @error('hindi_party_name') is-invalid @enderror"
                                        name="hindi_party_name" placeholder="{{ __('Enter Party Name In Hindi') }}"
                                        value="{{ $party_details->hindi_party_name }}">
                                    @error('hindi_party_name')
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
                                    <label for="name">{{ __('Party Description In English') }}</label>
                                    <input id="english_party_description" type="text"
                                        class="form-control @error('english_party_description') is-invalid @enderror"
                                        name="english_party_description"
                                        placeholder="{{ __('Enter Party Description In English') }}"
                                        value="{{ $party_details->english_party_description }}">
                                    @error('english_party_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 col-6">
                                <div class="form-group required-field text-left @error('name') is-invalid @enderror">
                                    <label for="name">{{ __('Party Description In Hindi') }}</label>
                                    <input id="hindi_party_description " type="text"
                                        class="form-control @error('hindi_party_description') is-invalid @enderror"
                                        name="hindi_party_description"
                                        placeholder="{{ __('Enter Party Description In Hindi') }}"
                                        value="{{ $party_details->hindi_party_description }}">
                                    @error('hindi_party_description')
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
                                    <label for="name">{{ __('Centre Image 1') }}</label>

                                    <div class="col-md-6">
                                        <input id="image" type="file"
                                            class="form-control-file @error('centre_image_first') is-invalid @enderror"
                                            name="centre_image_first" accept="image/*"
                                            onchange="previewCentreFirstImage(event)">
                                        @error('centre_image_first')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        {{-- <img id="imagePreviewCentreFirst" src="#" alt="Image Preview" class='square_image'
                                            style="display: none; max-width: 100%; margin-top: 10px;"> --}}
                                        <img id="imagePreviewCentreFirst" src="{{ $party_details->centre_image_first }}"
                                            alt="Image Preview" class='square_image'
                                            style="max-width: 100%; margin-top: 10px; {{ isset($party_details->centre_image_first) ? 'display: block;' : 'display: none;' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-6">
                                <div class="form-group required-field text-left @error('name') is-invalid @enderror">
                                    <label for="name">{{ __('Centre Image 2') }}</label>

                                    <div class="col-md-6">
                                        <input id="image" type="file"
                                            class="form-control-file @error('centre_image_second') is-invalid @enderror"
                                            name="centre_image_second" accept="image/*"
                                            onchange="previewCentreSecondImage(event)">
                                        @error('centre_image_second')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        {{-- <img id="imagePreviewCentreSecond" src="#" alt="Image Preview" class='square_image'
                                            style="display: none; max-width: 100%; margin-top: 10px;"> --}}
                                        <img id="imagePreviewCentreSecond"
                                            src="{{ $party_details->centre_image_second }}" alt="Image Preview"
                                            class='square_image'
                                            style="max-width: 100%; margin-top: 10px; {{ isset($party_details->centre_image_second) ? 'display: block;' : 'display: none;' }}">
                                    </div>
                                </div>
                            </div>

                        </div>



                        <div class="row mb-4">
                            <div class="col-xs-12 col-sm-12 col-md-12 formBtn">
                                {{-- <button type="submit" class="btn btn-primary">{{ __('Add') }}</button> --}}
                                <input type="submit" value="Edit" class="btn btn-primary">
                            </div>
                        </div>


                    </div>
                </div>


            </form>

        </div>
    </div>
@endsection
@section('pageJs')
    <script>
        function previewImage(event) {
            var image = document.getElementById('imagePreview');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.style.display = 'block';
        }

        function previewCentreFirstImage(event) {
            var image = document.getElementById('imagePreviewCentreFirst');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.style.display = 'block';
        }

        function previewCentreSecondImage(event) {
            var image = document.getElementById('imagePreviewCentreSecond');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.style.display = 'block';
        }
    </script>
@endsection
