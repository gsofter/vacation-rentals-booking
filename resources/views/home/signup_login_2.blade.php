<style type="text/css">
	.btn-large {
		padding: 20px 27px !important;
	}
</style>@extends('template')

@section('main')
	
	<main id="site-content" role="main">
		<div class="page-container-responsive page-container-auth margintop" style="margin-top:40px;margin-bottom:40px;">
			<div class="row">
				<div class="col-md-7 col-center">
					<div class="panel top-home bor-none">
						<div class="alert alert-with-icon alert-error alert-header panel-header hidden-element notice" id="notice">
							<i class="icon alert-icon icon-alert-alt"></i>
						</div>
						<div class="panel-padding panel-body pad-25">
							@include('forms.signup_email', ['form_id' => 'signup_email_form'])
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

@stop