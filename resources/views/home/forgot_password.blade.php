@extends('template')
@section('main')
    <main role="main" id="site-content">
        <div class="page-container-responsive page-container-auth" style="margin-top:40px; margin-bottom:40px;">
            <div class="row">
                <div class="col-md-7 col-lg-5 col-center">
                    <div class="panel top-home">
                        @include('forms.forgot_password', ['form_id' => 'forgot_password_form'])
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop