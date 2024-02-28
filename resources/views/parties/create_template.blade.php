<?php
use App\Components\Helper;
?>
@extends(\App\Components\Helper::getLayoutForUser())
@section('content')
    <div class="side-app">
        <div class="page-header page-header-wrap">
            <div class="page-header-left">
                <h1>{{ __('Create Template') }}</h1>
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
                                    <label for="name">{{ __('Backgroud Image') }}</label>

                                    <div class="col-md-6">
                                        <input type="file"
                                            class="form-control-file @error('background_image') is-invalid @enderror"
                                            name="background_image" accept="image/*" onchange="backgroundImage(event)">
                                        @error('background_image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <img id="backgroundImagePreview" src="#" alt="Image Preview"
                                            style="display: none; max-width: 100%; margin-top: 10px;">
                                    </div>
                                </div>
                            </div>
                        </div>



                        {{-- <div class="row">
                    <div class="col-md-6 col-6">
                        <div class="form-group required-field text-left @error('name') is-invalid @enderror">
                            <label for="name">{{ __('Centre Party Image 1') }}</label>

                    <div class="col-md-6">
                        <input type="file" class="form-control-file @error('centre_image_1') is-invalid @enderror" name="centre_image_1" accept="image/*" onchange="mainCentreImage1(event)">
                        @error('centre_image_1')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <img id="centreImagePreview1" src="#" alt="Image Preview" style="display: none; max-width: 100%; margin-top: 10px;">
                    </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-6">
                        <div class="form-group required-field text-left @error('name') is-invalid @enderror">
                            <label for="name">{{ __('Centre Party Image 2') }}</label>

                    <div class="col-md-6">
                        <input type="file" class="form-control-file @error('centre_image_2') is-invalid @enderror" name="centre_image_2" accept="image/*" onchange="mainCentreImage2(event)">
                        @error('centre_image_2')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <img id="centreImagePreview2" src="#" alt="Image Preview" style="display: none; max-width: 100%; margin-top: 10px;">
                    </div>
                        </div>
                    </div>
                    
                </div>




                <div class="row">
                    <div class="col-md-6 col-6">
                        <div class="form-group required-field text-left @error('name') is-invalid @enderror">
                            <label for="name">{{ __('State Party Image 1') }}</label>

                    <div class="col-md-6">
                        <input type="file" class="form-control-file @error('state_image_1') is-invalid @enderror" name="state_image_1" accept="image/*" onchange="stateImage1(event)">
                        @error('state_image_1')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <img id="stateImagePreview1" src="#" alt="Image Preview" style="display: none; max-width: 100%; margin-top: 10px;">
                    </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-6">
                        <div class="form-group required-field text-left @error('name') is-invalid @enderror">
                            <label for="name">{{ __('State Party Image 2') }}</label>

                    <div class="col-md-6">
                        <input type="file" class="form-control-file @error('state_image_2') is-invalid @enderror" name="state_image_2" accept="image/*" onchange="stateImage2(event)">
                        @error('state_image_2')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <img id="stateImagePreview2" src="#" alt="Image Preview" style="display: none; max-width: 100%; margin-top: 10px;">
                    </div>
                        </div>
                    </div>
                    
                </div>
               --}}


                        <div class="row mb-4">
                            <div class="col-xs-12 col-sm-12 col-md-12 formBtn">
                                {{-- <button type="submit" class="btn btn-primary">{{ __('Add') }}</button> --}}
                                <input type="submit" value="Add" class="btn btn-primary">
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
        function backgroundImage(event) {
            var image = document.getElementById('backgroundImagePreview');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.style.display = 'block';
        }

        function mainCentreImage1(event) {
            var image = document.getElementById('centreImagePreview1');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.style.display = 'block';
        }

        function mainCentreImage2(event) {
            var image = document.getElementById('centreImagePreview2');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.style.display = 'block';
        }

        function stateImage1(event) {
            var image = document.getElementById('stateImagePreview1');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.style.display = 'block';
        }

        function stateImage2(event) {
            var image = document.getElementById('stateImagePreview2');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.style.display = 'block';
        }
    </script>
@endsection
