@extends('layouts.main')

@section('content')

<main id="site-content" role="main">
    <div class="page-container-responsive page-container-auth margintop" style="margin-top:40px;margin-bottom:40px;">
        <div class="row">
            <div class="log_pop col-center">
                <div class="panel top-home">
                    <div class="panel-body pad-25 bor-none padd1 ">
                    <div class="signup-or-separator">
                        <span class="h6 signup-or-separator--text">{{ trans('messages.login.or')}}</span>  <hr>
                    </div>
                    <div class="clearfix"></div>

<form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}" class="vr_form signup-form login-form ng-pristine ng-valid" id="{{ $form_id or '' }}" data-action="Signin" novalidate="true">
    @csrf

    <div class="form-group row">
        <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

        <div class="col-md-6">
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

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
        <div class="col-md-6 offset-md-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Login') }}
            </button>

            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        </div>
    </div>
</form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
               
@endsection
