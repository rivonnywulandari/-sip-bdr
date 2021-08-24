@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'profile'
])

@section('content')
    <div class="content">
        @if (session('password_status'))
            <div class="alert alert-success" role="alert">
                {{ session('password_status') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <form class="col-md-12" action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ __('Change Password') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-2"></div>
                                <p class="col-sm-2 col-form-label">{{ __('Old Password') }}</p>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="password" name="old_password" class="form-control" placeholder="Old Password" required>
                                    </div>
                                    @if ($errors->has('old_password'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-2"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2"></div>
                                <p class="col-sm-2 col-form-label">{{ __('New Password') }}</p>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-2"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2"></div>
                                <p class="col-sm-2 col-form-label">{{ __('Password Confirmation') }}</p>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Password Confirmation" required>
                                    </div>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-2"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-info btn-round float-right mb-3">{{ __('Save Changes') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection