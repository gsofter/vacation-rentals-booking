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
            <div class="alert alert-with-icon alert-error alert-header panel-header hidden-element notice" id="notice">
              <i class="icon alert-icon icon-alert-alt"></i>
            </div>
            <div class="panel-padding panel-body pad-25 padd1">
              @include('forms.signup_type')
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

@stop