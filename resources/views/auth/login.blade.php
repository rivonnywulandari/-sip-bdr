@extends('layouts.app', [
    'class' => 'login-page',
    'backgroundImagePath' => 'img/bg/classroom.jpg'
])

@section('content')
    <div class="content">
        <div class="container">
            <div class="col-lg-4 col-md-6 ml-auto mr-auto">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ $errors->first() }}
                        <button type="button" aria-hidden="true" class="close" data-dismiss="alert"
                            aria-label="Close">
                            <i class="nc-icon nc-simple-remove"></i>
                        </button>
                    </div>
                @endif
            </div>
            <div class="col-lg-4 col-md-6 ml-auto mr-auto">
                <form class="form" method="POST" action="{{ route('login-verify') }}">
                    @csrf
                    <div class="card card-login">
                        <div class="card-header ">
                            <div class="card-header">
                                <h3 class="header text-center">{{ __('Login') }}</h3>
                            </div>
                        </div>
                        <div class="card-body ">

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                <input class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="{{ __('Username') }}" type="text" name="username" value="{{ old('username') }}" required autofocus>
                                
                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-key-25"></i>
                                    </span>
                                </div>
                                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" type="password" required>
                                
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                     <label class="form-check-label">
                                        <input class="form-check-input" name="remember" type="checkbox" value="" {{ old('remember') ? 'checked' : '' }}>
                                        <span class="form-check-sign"></span>
                                        {{ __('Remember me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-round mb-3">{{ __('Sign in') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();
        });
    </script>
@endpush