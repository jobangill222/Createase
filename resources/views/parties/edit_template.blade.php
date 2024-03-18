<?php
use App\Components\Helper;
?>
@extends(\App\Components\Helper::getLayoutForUser())
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div class="side-app">
        <div class="page-header page-header-wrap">
            <div class="page-header-left">
                <h1>{{ __('Edit Template') }}</h1>
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
                            <div class="col-md-6 col-6">
                                <div class="form-group required-field text-left @error('name') is-invalid @enderror">
                                    <label for="state_id">{{ __('State') }}</label>
                                    <select class="form-control" id="state_id" name="state_id[]" multiple="multiple">
                                    <option value="all">Select All</option> 
                                        

                                        @foreach ($states as $item)
                                            @php
                                                $isSelected = false;
                                                if ($template_details->state_id) {
                                                    if (is_array(json_decode($template_details->state_id, true))) {
                                                        // If state_id is a JSON string
                                                        $isSelected = in_array($item->id, json_decode($template_details->state_id, true));
                                                    } else {
                                                        // If state_id is an integer
                                                        $isSelected = ($item->id == $template_details->state_id);
                                                    }
                                                }
                                            @endphp
                                            <option value="{{ $item->id }}" @if ($isSelected) selected @endif>
                                                {{ $item->english_name }}
                                            </option>
                                        @endforeach


                                    </select>
                                    @error('state_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <?php
                        // dd($template_details->filter_ids);
                        // dd(in_array('1', json_decode($template_details->filter_ids)));
                        ?>

                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="form-group required-field text-left @error('name') is-invalid @enderror">
                                    <label for="state_id">{{ __('Filter') }}</label>
                                    <select id="filter" name="filter[]" multiple="multiple" class="form-control"
                                        required="">
                                        <option value="all">Select All</option> 
                                        

                                        @foreach ($filters as $item)
                                            @if ($template_details->filter_ids)
                                                @php
                                                    $isSelected = in_array(
                                                        $item->id,
                                                        json_decode($template_details->filter_ids),
                                                    );
                                                @endphp
                                                <option value="{{ $item->id }}"
                                                    @if ($isSelected) selected @endif>
                                                    {{ $item->english_name }}
                                                </option>
                                            @else
                                                <option value="{{ $item->id }}">{{ $item->english_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('filter')
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
                                    <label for="state_id">Color Code</label>
                                    <input type="text" name="color_code" value="{{$template_details->color_code}}" class="form-control" placeholder="#FFFFFF">
                                </div>
                            </div>
                        </div>
    
    
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="form-group required-field text-left @error('name') is-invalid @enderror">
                                    <label for="state_id">Designation Color code</label>
                                    <input type="text" name="designation_color_code" value="{{$template_details->designation_color_code}}" class="form-control" placeholder="#FFFFFF">
                                </div>
                            </div>
                        </div>





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
                                        {{-- <img id="backgroundImagePreview" src="#" alt="Image Preview"
                                            class='square_image' style="display: none; max-width: 100%; margin-top: 10px;"> --}}
                                        <img id="backgroundImagePreview" src="{{ $template_details->background_image }}"
                                            alt="Image Preview" class='square_image'
                                            style="max-width: 100%; margin-top: 10px; {{ isset($template_details->background_image) ? 'display: block;' : 'display: none;' }}">
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


    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
    $(document).ready(function() {
        $('#filter, #state_id').select2({
            placeholder: 'Select',
            allowClear: true // This allows clearing the selection
        });

        // Handle "Select All" option for State
        $('#state_id').on('select2:select', function(e) {
            if ($(this).val() != null && $(this).val().includes('all')) {
                $(this).val([...$(this).find('option').not(':first').map(function() {
                    return this.value;
                })]).trigger('change');
            }
        });

        $('#state_id').on('select2:unselect', function(e) {
            if ($(this).val() != null && !$(this).val().includes('all')) {
                // Check if "Select All" is still selected
                if ($('#state_id option[value="all"]').is(':selected')) {
                    // If "Select All" is still selected, don't reset the selection
                    return;
                }
            }
        }); 


        $('#filter').on('select2:select', function(e) {
            if ($(this).val() != null && $(this).val().includes('all')) {
                $(this).val([...$(this).find('option').not(':first').map(function() {
                    return this.value;
                })]).trigger('change');
            }
        });

        $('#filter').on('select2:unselect', function(e) {
            if ($(this).val() != null && !$(this).val().includes('all')) {
                // Check if "Select All" is still selected
                if ($('#filter option[value="all"]').is(':selected')) {
                    // If "Select All" is still selected, don't reset the selection
                    return;
                }
            }
        }); 

 
    });
</script>

@endsection
