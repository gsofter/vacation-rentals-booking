@include('common.head')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-ajax-file-upload@1.0.0/jquery.ajaxfileupload.min.js"></script>
<!--<script async  src="{{asset('dist/client/js/plugin/plugins.min.js')}}"></script>-->

@if(!isset($exception))
	@if (Route::current()->uri() != 'api_payments/book/{id?}' && Route::current()->uri() != 'home/cancellation_policies') 
	 	@if(Session::get('get_token')=='')
	   		@include('common.header')
	 	@endif
	@endif
@else   
        @if(Session::get('get_token')=='')
   			@include('common.header')
   		@endif
@endif

@yield('main')

@if (!isset($exception))
	@if (Route::current()->uri() != 'payments/book/{id?}' && Route::current()->uri() != 'reservation/receipt' && Route::current()->uri() != 'api_payments/book/{id?}' && Route::current()->uri() != 'home/cancellation_policies')
	    @if(Session::get('get_token')=='')
		   @include('common.footer')
		@endif
	@endif
@else
    @if(Session::get('get_token')=='')
		@include('common.footer')
	@endif
@endif

@include('common.foot')