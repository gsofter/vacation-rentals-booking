<style type="text/css">
    .btn-large {
        padding: 20px 27px !important;
    }
</style>
@extends('template')

@section('main')
    
    <main id="site-content" role="main">
        <div class="page-container-responsive page-container-auth margintop" style="margin-top:40px;margin-bottom:40px;">
            <div class="row">
                <div class="log_pop col-center">
                    <div class="panel top-home">
                        <div class="panel-body pad-25 bor-none padd1 ">
                            @include('forms.login', ['form_id' => 'login_form'])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop