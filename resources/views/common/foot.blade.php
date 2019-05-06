<div id="gmap-preload" class="hide"></div>
<div class="ipad-interstitial-wrapper"><span data-reactid=".1"></span></div>
<div id="fb-root"></div>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-ajax-file-upload@1.0.0/jquery.ajaxfileupload.min.js"></script> -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ $map_key }}&libraries=places&language={{ (Session::get('language')) ? Session::get('language') : $default_language[0]->value }}"></script>

<!-- my bundled scripts -->
<!-- {!! Html::script('dist/client/js/plugin/plugins.min.js') !!} -->

@if (Route::current()->uri() == 'conversation/{user_id}')
    {!! Html::script('dist/client/js/business/app.js') !!}
@endif


@if(Session::get('language') != 'en')
    {!! Html::script('js/i18n/datepicker-'.Session::get('language').'.js') !!}
@endif

{!! Html::script('dist/client/js/business/phone-validation.min.js') !!}


<script type="text/javascript">
    var app=angular.module('App',['ngSanitize', 'ui.tinymce', 'ui.toggle', 'ngIntlTelInput']).config(function (ngIntlTelInputProvider) {
        ngIntlTelInputProvider.set({separateDialCode: false});
    });
    var APP_URL={!!json_encode(url('/'))!!};var LANGUAGE_CODE="{!! (Session::get('language')) ? Session::get('language') : $default_language[0]->value !!}";var USER_ID={!!@Auth::user()->id?@Auth::user()->id:json_encode([])!!};var more_text_lang="{{trans('messages.profile.more')}}";var validation_messages={!!json_encode(trans('validation'))!!};$.datepicker.setDefaults($.datepicker.regional["{{ (Session::get('language')) ? Session::get('language') : $default_language[0]->value }}"]);
</script>

{!! $head_code !!}

{!! Html::script('dist/client/js/business/common.min.js?v='.$version) !!}
{!! Html::script('dist/client/js/business/custom.min.js?v='.$version) !!}

@if (!isset($exception))
    @if (Route::current()->uri() == '/')
        @if(@$default_home == 'two')
            {!! Html::script('dist/client/js/business/home_two.min.js?v='.$version) !!}
        @endif
    @endif
    @if (Route::current()->uri() == 'rooms/new')
        {!! Html::script('dist/client/js/business/rooms_new.min.js?v='.$version) !!}
        {!! Html::script('dist/client/js/business/home_two.min.js?v='.$version) !!}
    @endif
    @if (Route::current()->uri() == 'manage-listing/{id}/{page}')
        {!! Html::script('vendors/tinymce/tinymce.min.js') !!}

        {!! Html::script('dist/client/js/business/manage_listing.min.js?v='.$version) !!}
        {!! Html::script('dist/client/js/business/home_two.min.js?v='.$version) !!}
    @endif
    @if (Route::current()->uri() == 's' || Route::current()->uri() == '{locations}')
        {!! Html::script('dist/client/js/business/home_two.min.js?v='.$version) !!}
    @endif
    @if (Route::current()->uri() == 'trips/current'||Route::current()->uri() == 'trips/previous'||Route::current()->uri() == 'users/transaction_history'||Route::current()->uri() == 'users/security'|| Route::current()->uri() == 'dashboard')
        {!! Html::script('dist/client/js/business/home_two.min.js?v='.$version) !!}
    @endif
    @if (Route::current()->uri() == 'rooms/{id}'|| Route::current()->uri() == '{address}/{id}')
        {!! Html::script('dist/client/js/business/rooms.min.js?v='.$version) !!}
        {!! Html::script('dist/client/js/business/home_two.min.js?v='.$version) !!}
    @endif
    @if (Route::current()->uri() == 'reservation/change'|| Route::current()->uri() == 'reservation/{id}')
        {!! Html::script('dist/client/js/business/home_two.min.js?v='.$version) !!}
        {!! Html::script('dist/client/js/business/reservation.min.js?v='.$version) !!}
    @endif
    @if (Route::current()->uri() == 'wishlists/popular' || Route::current()->uri() == 'wishlists/my' || Route::current()->uri() == 'wishlists/picks' || Route::current()->uri() == 'wishlists/{id}' || Route::current()->uri() == 'users/{id}/wishlists')
        {!! Html::script('dist/client/js/business/wishlists.min.js?v='.$version) !!}
        {!! Html::script('dist/client/js/business/home_two.min.js?v='.$version) !!}
    @endif
    @if (Route::current()->uri() == 'inbox' || Route::current()->uri() == 'z/q/{id}' || Route::current()->uri() == 'messaging/qt_with/{id}')
        {!! Html::script('dist/client/js/business/inbox.min.js?v='.$version) !!}
        {!! Html::script('dist/client/js/business/home_two.min.js?v='.$version) !!}
    @endif
    @if(Route::current()->uri() == 'disputes' || Route::current()->uri() == 'dispute_details/{id}' )
        {!! Html::script('dist/client/js/business/disputes.min.js?v='.$version) !!}
    @endif
    @if (Route::current()->uri() == 'manage-listing/{id}/subscribe_property')
        {!! Html::script('admin_assets/plugins/jQuery/jquery.validate.js') !!}
        {!! Html::script('js/manage_subscribe.js') !!}
        {!! Html::script('js/sweetalert2.all.js') !!}
        {!! Html::script('https://js.stripe.com/v2/?v='.$version) !!}
        {!! Html::script('https://js.braintreegateway.com/js/braintree-2.30.0.min.js?v='.$version) !!}
    @endif
@endif
@if (Request::segment(1) == 'host' || Request::segment(1) == 'experiences')
    {!! Html::script('js/host_experiences/owl.carousel.js') !!}
    {!! Html::script('js/host_experiences/host_experience.js?v='.$version) !!}
@endif
@if (Route::current()->uri() == 'blog' || Route::current()->uri() == 'blog/{slug}' || Route::current()->uri() == 'blog/category/{slug}' || Route::current()->uri() == 'blog/author/{username}' || Route::current()->uri() == 'blog/tag/{slug}' )
@endif
@stack('scripts')
@if(!empty(Session::get('error_code')) && Session::get('error_code') == 5)
    <script>
        $(function(){
            $('.login_popup').show();
            $('.signup_popup').hide();
            $('.signup_popup2').hide();
            $('.forgot-passward').hide()
        });
    </script>
@endif
@if(!empty(Session::get('error_code')) && Session::get('error_code') == 1)
    <script>
        $(function(){
            $('.login_popup').hide();
            $('.signup_popup2').show();
            $('.signup_popup').hide();
            $('.forgot-passward').hide()
        });
    </script>
@endif
@if(!empty(Session::get('error_code')) && Session::get('error_code') == 4)
    <script>
        $(function(){
            $('.login_popup').hide();
            $('.signup_popup').hide();
            $('.signup_popup2').hide();
            $('.forgot-passward').show()
        });
    </script>
@endif
<script type="text/javascript">
    
    $('#searchbar-form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
</script>

</body>
    </html>
