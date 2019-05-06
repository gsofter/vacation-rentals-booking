@extends('template')
@section('main')
  <main id="site-content" role="main">
    <div class=" page-container-responsive row-space-top-8 row-space-8">
      <div class="row">
        <div class="col-4 col-center">
          <div class="panel">
            <div class="panel-header">
              {{ trans('messages.login.reset_your_pwd') }}
            </div>
            <div class="panel-body">
              @include('forms.set_password', ['form_id' => 'set_password_form'])
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@stop