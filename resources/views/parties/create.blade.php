<?php
use App\Components\Helper;
?>
@extends(\App\Components\Helper::getLayoutForUser())
@section('content')
    <div class="side-app">
        <div class="page-header page-header-wrap">
            <div class="page-header-left">
                <h1>{{__('Add Parties')}}</h1>
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
                                    <input type="text" name="q" value="" class="form-control filterField" placeholder="Enter Search">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group text-left">
                                    <label for="status">{{ __('Status') }}</label>
                                    <select name="status" id="status" class="form-control filterField">
                                        <option value="">Select Status</option>
                                        @foreach (\App\Constants\UserConstants::STATUS_PROPERTIES as $userStatus => $userStatusData)
                                            <option value="{{$userStatus}}">{{$userStatusData['text']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <form id="validate-from" method="post" enctype="multipart/form-data" >
            {{csrf_field()}}


            <div class="card" >

            <div class="card-body" >


                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group required-field text-left @error('name') is-invalid @enderror">
                            <label for="name">{{ __('Party Name') }}</label>

                    <div class="col-md-6">
                        <input id="image" type="file" class="form-control-file @error('image') is-invalid @enderror" name="image" accept="image/*" onchange="previewImage(event)">
                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 100%; margin-top: 10px;">
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
                                value="{{ old('english_party_name') }}">
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
                                value="{{ old('hindi_party_name') }}">
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
                                name="english_party_description" placeholder="{{ __('Enter Party Description In English') }}"
                                value="{{ old('english_party_description') }}">
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
                                name="hindi_party_description" placeholder="{{ __('Enter Party Description In Hindi') }}"
                                value="{{ old('hindi_party_description') }}">
                            @error('hindi_party_description')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
        
                    
        
                </div>

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
    function previewImage(event) {
        var image = document.getElementById('imagePreview');
        image.src = URL.createObjectURL(event.target.files[0]);
        image.style.display = 'block';
    }
</script>

@endsection
