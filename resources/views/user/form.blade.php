<div class="rounded-16 form-box bg-white -dark-bg-dark-1 shadow-4 h-100">
    <form action="{{ $user->id ==null ? route('user.store') : route('user.update', $user) }}" method="POST"
          class="normal-form">
        @csrf

        @if( $user->id != null )
            @method('PUT')
        @endif

        <div class="row">

            <div class="col-md-6 col-12">
                <div class="form-group required-field text-left @error('username') is-invalid @enderror">
                    <label for="username">{{ __('Username') }}</label>
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                           name="username" placeholder="{{ __('Enter Username') }}"
                           value="{{old('username', $user->username)}}">
                    @error('username')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="form-group required-field text-left @error('email') is-invalid @enderror">
                    <label for="email">{{ __('Email') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" placeholder="{{ __('Enter Email') }}"
                           value="{{old('email', $user->email)}}">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-md-6 col-12">
                <div class="form-group required-field text-left @error('name') is-invalid @enderror">
                    <label for="name">{{ __('Name') }}</label>
                    <input id="name" type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           name="name" placeholder="{{ __('Enter Name') }}"
                           value="{{old('name', $user->name)}}">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="form-group required-field text-left @error('status') is-invalid @enderror">
                    <label for="status">{{ __('Status') }}</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                        @foreach (\App\Constants\UserConstants::STATUS_PROPERTIES as $userStatus => $userStatusData)
                            <option
                                {{  $userStatus === $user->status ? 'selected="selected"': ''}} value="{{$userStatus}}">{{$userStatusData['text']}}</option>
                        @endforeach
                    </select>
                    @error('status')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

        </div>

        @if( $user->id == null )

            <hr>

            <div class="row">

                <div class="col-md-6 col-12">
                    <div class="form-group required-field text-left @error('password') is-invalid @enderror">
                        <label id="password">{{ __('New Password') }}</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password"
                               value="{{ old('password') }}" placeholder="{{ __('Enter New Password') }}">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div
                        class="form-group required-field text-left @error('password_confirmation') is-invalid @enderror">
                        <label id="password_confirmation">{{ __('Confirm Password') }}</label>
                        <input id="password_confirmation" type="password"
                               class="form-control @error('password_confirmation') is-invalid @enderror"
                               name="password_confirmation" value="{{ old('password_confirmation') }}"
                               placeholder="{{ __('Confirm Password') }}">
                        @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                        @enderror
                    </div>
                </div>

            </div>

        @endif

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
