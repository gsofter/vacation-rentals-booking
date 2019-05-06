<style type="text/css">
  .btn-large {
    padding: 20px 27px !important;
  }
</style>
@extends('layouts.main')

@section('content')
<main id="site-content" role="main">
    <div class="page-container-responsive page-container-auth margintop" style="margin-top:40px;margin-bottom:40px;">
        <div class="row">
            <div class="col-md-7 col-center">
                <div class="panel top-home bor-none">
                    <div class="alert alert-with-icon alert-error alert-header panel-header hidden-element notice" id="notice">
                        <i class="icon alert-icon icon-alert-alt"></i>
                    </div>
                    <div class="panel-padding panel-body pad-25">

                        <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" >

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                                
                            <div class="bottom-panel1 text-center ">
                            <hr>
                            {{ trans('messages.login.already_an') }} {{ $site_name }} {{ trans('messages.login.member') }}
                            <a href="{{ url('login') }}" class="width-100 modal-link link-to-login-in-signup login-btn login_popup_head link_color " data-modal-href="/login_modal?" data-modal-type="login">
                                {{ trans('messages.header.login') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>    
@endsection
