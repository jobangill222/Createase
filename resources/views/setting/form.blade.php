<div class="rounded-16 form-box bg-white -dark-bg-dark-1 shadow-4 h-100">
    <form action="{{ $setting->id ==null ? route('setting.store') : route('setting.update', $setting) }}" method="POST"
          class="normal-form">
        @csrf

        @if( $setting->id != null )
            @method('PUT')
        @endif

        <?php
        if(in_array($setting->id,[
            //\App\Constants\CommonConstants::SETTING_GAME_STATUS,
            ])) {
            ?>
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="form-group required-field text-left @error('value') is-invalid @enderror">
                        <label for="value">{{ __('Value') }}</label>
                        <select class="form-control @error('value') is-invalid @enderror" name="value" id="value">
                            <option <?=($setting->value=="on" ? 'selected=""' : '')?> value="on">On</option>
                            <option <?=($setting->value=="off" ? 'selected=""' : '')?> value="off">Off</option>
                        </select>
                        @error('value')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <?php
        } else { ?>
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="form-group required-field text-left @error('value') is-invalid @enderror">
                        <label for="value">{{ __('Value') }}</label>
                        <input id="value" type="text"
                               class="form-control @error('value') is-invalid @enderror"
                               name="value" placeholder="{{ __('Enter value') }}"
                               value="{{old('value', $setting->value)}}">
                        @error('value')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 formBtn">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
            </div>
        </div>

    </form>
</div>

@section('pageJs')

    <script>

    </script>

@endsection
