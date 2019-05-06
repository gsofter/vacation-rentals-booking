<!-- my bundled scripts -->
<script type="text/js" src="{{ asset('dist/client/js/plugin/plugins.min.js') }}"></script>
<div id="header" class="makent-header {{@$header_class}} new {{ (!isset($exception)) ? (Route::current()->uri() == '/' ? 'shift-with-hiw' : '') : '' }}">
  <header class="header--sm show-sm" aria-hidden="true" role="banner">
    <a href="{{ url('/') }}" aria-label="Homepage" data-prevent-default="" class="header-logo rj_logo_mob" style="background-image: url({{ URL::asset('images/logos/logo.png') }}); background-size: 100px;"></a>
    <div class="title--sm text-center">
      <button class="btn btn-block search-btn--sm search-modal-trigger">
        <i class="fa fa-map-marker new_header_marker" aria-hidden="true"></i>
        <span class="search-placeholder--sm">
          {{ trans('messages.header.where_are_you_going') }}
        </span>
      </button>
    </div>
    <a href="javascript:void(0);" aria-label="Homepage" data-prevent-default="" class="link-reset burger--sm header-logo rj_menu_mob">
      <i class="fa fa-bars lang-chang-label arrow-icon1"></i>
      <span class="screen-reader-only">
      Vacation Rentals From Owners And Property Managers
      </span>
    </a>
    <div class="action--sm"></div>
    <nav role="navigation" class="nav--sm"><div class="nav-mask--sm"></div>
      <div class="nav-content--sm panel">
        <div class="nav-header {{ (Auth::user()) ? '' : 'items-logged-in' }}">
          <div class="nav-profile clearfix">
            <div class="user-item text-center">
              <a href="{{ url('/') }}/users/show/{{ (Auth::user()) ? Auth::user()->id : '0' }}" class="link-reset user-profile-link">
                <div class="media-photo media-round user-profile-image" style="background:rgba(0, 0, 0, 0) url({{ (Auth::user()) ? Auth::user()->profile_picture->header_src : '' }}) no-repeat scroll 0 0 / cover">
                </div>
                {{ (Auth::user()) ? Auth::user()->first_name : 'User' }}
              </a>
            </div>
          </div>
          <hr>
        </div>
        <div class="nav-menu-wrapper">
          <div class="va-container va-container-v va-container-h">
            <div class=" nav-menu panel-body">
              <ul class="menu-group list-unstyled row-space-3 text-center">
                <li class="{{ (Auth::user()) ? 'items-logged-out' : '' }}">
                  <a rel="nofollow" class="link-reset menu-item text-center " href="{{ url('/') }}/login" data-login-modal="">
                    {{ trans('messages.header.login') }}
                  </a>
                </li>
                <li class="{{ (Auth::user()) ? 'items-logged-out' : '' }}">
                  <a rel="nofollow" class="link-reset menu-item  text-center" href="{{ url('/') }}/signup_login" data-signup-modal="">
                    {{ trans('messages.header.signup') }}
                  </a>
                </li>
                <li class="{{ (Auth::user()) ? '' : 'items-logged-in' }}">
                  <a href="{{ url('dashboard') }}" rel="nofollow" class="link-reset menu-item text-center">
                    {{ trans('messages.header.dashboard') }}
                  </a>
                </li>
                <li class="{{ (Auth::user()) ? '' : 'items-logged-in' }}">
                  <a href="{{ url('users/edit') }}" rel="nofollow" class="link-reset menu-item text-center">
                    {{ trans('messages.header.profile') }}
                  </a>
                  {{--<div class="child_1g2dfiu-o_O-child_alignMiddle_13gjrqj"  style="padding: 10px;"><svg viewBox="0 0 24 24" role="presentation" aria-hidden="true" focusable="false" style="display: block; fill: currentcolor; height: 26px; width: 26px;"><path fill-rule="evenodd"></path></svg></div>--}}
                </li>
                <li class="{{ (Auth::user()) ? '' : 'items-logged-in' }}">
                  <a href="{{ url('users/security') }}" rel="nofollow" class="link-reset menu-item text-center">
                    {{ trans('messages.header.account') }}
                  </a>
                </li>
                <li class="{{ (Auth::user()) ? '' : 'items-logged-in' }}">
                  <a class="link-reset menu-item  text-center" rel="nofollow" href="{{ url('/') }}/trips/current">
                    {{ trans('messages.header.Trips') }}
                  </a>
                  {{--<div class="child_1g2dfiu-o_O-child_alignMiddle_13gjrqj"  style="padding: 10px;"><svg viewBox="0 0 24 24" role="presentation" aria-hidden="true" focusable="false" style="display: block; fill: currentcolor; height: 26px; width: 26px;"><path fill-rule="evenodd"></path></svg></div>--}}
                </li>
                <li class="{{ (Auth::user()) ? '' : 'items-logged-in' }}  text-center">
                  <a class="link-reset menu-item" rel="nofollow" href="{{ url('/') }}/inbox">
                    {{ trans_choice('messages.dashboard.message2', 2) }}
                    {{--<i class="alert-count unread-count--sm fade">0</i>--}}
                  </a>
                  {{--<div class="child_1g2dfiu-o_O-child_alignMiddle_13gjrqj" style="padding: 10px;"><svg viewBox="0 0 24 24" role="presentation" aria-hidden="true" focusable="false" style="display: block; fill: currentcolor; height: 26px; width: 26px;"><path fill-rule="evenodd"></path></svg></div>--}}
                </li>
                <li class="{{ (Auth::user()) ? '' : 'items-logged-in' }}">
                  <a href="{{ url('rooms') }}" class="link-reset menu-item text-center" rel="nofollow">
                    {{ trans_choice('messages.header.your_listing', 2) }}
                  </a>
                </li>
              </ul>
              <ul class="menu-group list-unstyled row-space-3 text-center">
                <li>
                  <a class="link-reset menu-item" rel="nofollow" href="{{ url('/') }}/help">
                    help
                  </a>
                </li>
                <li>
                  <a class="link-reset menu-item " rel="nofollow" href="{{ url('contact') }}">
                    Contact Us
                  </a>
                </li>
                <li class="{{ (Auth::user()) ? '' : 'items-logged-in' }}">
                  <a class="link-reset menu-item logout" rel="nofollow" href="{{ url('/') }}/logout">
                    logout
                  </a>
                </li>
                <li class="{{ (Auth::user()) ? 'items-logged-out' : '' }} list_your_home_btn">
                  <a rel="nofollow" class="link-reset menu-item " href="{{ url('/') }}/login" data-login-modal="">
                    {{ trans('messages.header.head_homes') }}
                  </a>
                </li>
                <li  class="{{ (Auth::user()) ? '' : 'items-logged-in' }} list_your_home_btn">
                  <a rel="nofollow" class="link-reset menu-item" href="{{ url('rooms/new') }}">
                    {{ trans('messages.header.head_homes') }}
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </nav>

    <div class="search-modal-container moched">
      <div class="modal hide" role="dialog" id="search-modal--sm" aria-hidden="false" tabindex="-1">
        <div class="modal-table">
          <div class="modal-cell">
            <div class="modal-content">
              <div class="panel-header modal-header">
                <a href="#" class="modal-close" data-behavior="modal-close">
                  <span class="screen-reader-only">{{ trans('messages.home.close') }}</span>
                  <span class="aria-hidden"></span>
                </a>
                {{ trans('messages.home.search') }}
              </div>
              <div class="panel-body">
                <div class="modal-search-wrapper--sm">
                  <input type="hidden" name="source" value="mob">
                  <div class="row">
                    <div class="searchbar__location-error hide" style="left:22px; top:2%;">{{ trans('messages.home.search_validation') }}</div>
                    <div class="col-sm-12">
                      <label for="header-location--sm">
                        <span class="screen-reader-only">{{ trans('messages.header.where_are_you_going') }}</span>
                        <input type="text" placeholder="{{ trans('messages.header.where_are_you_going') }}" autocomplete="off" name="locations" id="header-search-form-mob" class="input-large" value="{{ @$location }}">
                      </label>
                    </div>
                  </div>
                  <div class="row row-condensed">
                    <div class="col-sm-6">
                      <label class="checkin">
                        <span class="screen-reader-only">{{ trans('messages.home.checkin') }}</span>
                        <input type="text" readonly="readonly" onfocus="this.blur()" autocomplete="off" name="checkin" id="modal_checkin" class="checkin input-large ui-datepicker-target" placeholder="{{ trans('messages.home.checkin') }}" value="{{ @$checkin }}">
                      </label>
                    </div>
                    <div class="col-sm-6">
                      <label class="checkout">
                        <span class="screen-reader-only">{{ trans('messages.home.checkout') }}</span>
                        <input type="text" readonly="readonly" onfocus="this.blur()" autocomplete="off" name="checkout" id="modal_checkout" class="checkout input-large ui-datepicker-target" placeholder="{{ trans('messages.home.checkout') }}" value="{{ @$checkout }}">
                      </label>
                    </div>
                  </div>
                  <div class="row space-2 space-top-1">
                    <div class="col-sm-12">
                      <label for="header-search-guests" class="screen-reader-only">
                        {{ trans('messages.home.no_of_guests') }}
                      </label>
                      <div class="select select-block select-large">
                        <select id="modal_guests" name="guests--sm">
                          @for($i=1;$i<=16;$i++)
                            <option value="{{ $i }}" {{ ($i == @$guest) ? 'selected' : '' }}>{{ $i }} guest{{ ($i>1) ? 's' : '' }}</option>
                          @endfor
                        </select>
                      </div>
                    </div>
                  </div>
                {{--
				<div class="panel-new-header menu-header normal-line-height st_menuu">
				  <strong>{{ trans('messages.referrals.explore') }}</strong>
				  <ul class="header_refinement_ul">
				  <input type="hidden" name="header_refinement" class="header_refinement_input" value="Homes">
				  <li><button class="header_refinement in_form active" data="Homes" type="button" id="ftb">{{ trans('messages.header.homes') }}</button></li>
				  <li><button class="header_refinement in_form" data="Experiences" type="button" id="ftb1">{{ trans_choice('messages.home.experience',1) }}</button></li>
				  </ul>
				</div>
				--}}
               
                  <div class="row row-space-top-2">
                    <div class="col-sm-12">
                      <button type="button" id="search-form--sm-btn" class="btn btn-primary btn-large btn-block">
                        <i class="icon icon-search"></i>
                        {{ trans('messages.header.find_place') }}
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <header class="regular-header clearfix hide-sm bttm_border" id="old-header-hide" role="banner">
    <a aria-label="Homepage" style="background-image: url({{ URL::asset('images/logos/logo.png') }}); background-size: 145px;" href="{{ url('/') }}" class="header-belo header-logo pull-left {{ (!isset($exception)) ? (Route::current()->uri() == '/' ? 'home-logo' : '') : '' }}" >
      <span class="screen-reader-only">
      Vacation Rentals From Owners And Property Managers
      </span>
    </a>
    <div class="pull-left search-input-home resp-ipod ne_hed">
      @if (!isset($exception))
        @if(Request::segment(1) != 'help' && Route::current()->uri() != '/')
          <ul class="nav pull-left  list-unstyled search-form-container" id="search-form-header">
            <li id="header-search" class="search-bar-wrapper pull-left medium-right-margin">
              <form action="{{ url('/') }}/s" class="search-form">
                <div class="search-bar">
                  <i class="fa fa-map-marker new_header_marker" aria-hidden="true"></i>
                  <label class="screen-reader-only" for="header-search-form">{{ trans('messages.header.search_box_placeholder') }}</label>
                  <input type="text" placeholder="{{ trans('messages.header.search_box_placeholder') }}" autocomplete="off" name="locations" id="header-search-form" class="location" value="">
                  {{--
				  <div class="panel-new-header menu-header normal-line-height search_new_header">
					<strong>{{ trans('messages.referrals.explore') }}</strong>
					<ul class="header_refinement_ul">
					<input type="hidden" name="header_refinement" class="header_refinement_input" value="Homes">
					<li><button class="header_refinement active" data="Homes" type="button">{{ trans('messages.header.homes') }}</button>
					</li>
					<li><button class="header_refinement" data="Experiences" type="button">{{ trans_choice('messages.home.experience',1) }}</button></li>
					</ul>
				  </div>
				  --}}
                </div>
                <div class="searchbar__location-error" style="display: none;">Please set location</div>
                <div id="header-search-settings" class="panel search-settings header-menu rem_hed">
                  <div class="panel-body clearfix basic-settings">
                    <div class="setting checkin lang-chang-label">
                      <label for="header-search-checkin" class="field-label">
                        <strong>{{ trans('messages.home.checkin') }}</strong>
                      </label>
                      <input type="text" readonly="readonly" autocomplete="off" id="header-search-checkin" data-field-name="check_in_dates" class="checkin ui-datepicker-target" onfocus="this.blur()"  placeholder="{{ trans('messages.rooms.dd-mm-yyyy') }}">
                      <input type="hidden" name="checkin">
                    </div>
                    <div class="setting checkout lang-chang-label">
                      <label for="header-search-checkout" class="field-label">
                        <strong>{{ trans('messages.home.checkout') }}</strong>
                      </label>
                      <input type="text" readonly="readonly" autocomplete="off" id="header-search-checkout" data-field-name="check_out_dates" class="checkout ui-datepicker-target" onfocus="this.blur()"  placeholder="{{ trans('messages.rooms.dd-mm-yyyy') }}">
                      <input type="hidden" name="checkout">
                    </div>
                    <div class="setting guests lang-chang-label">
                      <label for="header-search-guests" class="field-label">
                        <strong>{{ trans_choice('messages.home.guest', 2) }}</strong>
                      </label>
                      <div class="select select-block">
                        <select id="header-search-guests" data-field-name="number_of_guests" name="guests">
                          @for($i=1;$i<=16;$i++)
                            <option value="{{ $i }}"> {{ ($i == '16') ? $i.'+ ' : $i }} </option>
                          @endfor
                        </select>
                      </div>
                    </div>
                  </div>
                  {{--
				  <div class="panel-new-header menu-header normal-line-height st_menuu">
					<strong>{{ trans('messages.referrals.explore') }}</strong>
					<ul class="header_refinement_ul">
					<input type="hidden" name="header_refinement" class="header_refinement_input" value="Homes">
					<li><button class="header_refinement active" data="Homes" type="button" id="ftbm">{{ trans('messages.header.homes') }}</button></li>
					<li><button class="header_refinement" data="Experiences" type="button" id="ftbm1">{{ trans_choice('messages.home.experience',1) }}</button></li>
					</ul>
				  </div>
				  --}}
                  <div class="home_de">
                    <div class="home_pro">
                      <div class="home_check">
                        <strong>{{ trans('messages.header.room_type') }}</strong>
                        <div class="rom_ty" id="content-1">
                          
                            <div class="col-md-12 margin-top-10">
                              <div class="row">
                                <div class="holecheck">
                                  <div class="">
                                    <input type="checkbox" value="" id="room-type-" class="head_room_type"  />
                                   
                                      <i class="icon icon-entire-place h5 needsclick"></i>
                                 
                                      <i class="icon icon-private-room h5 needsclick"></i>
                                
                                      <i class="icon icon-shared-room h5 needsclick"></i>
                                
                                      <i class="icon icon1-home-building-outline-symbol2 h5 needsclick"></i>
                           
                                    <label class="search_check_label" for="room-type-"></label>
                                  </div>
                                </div>
                              </div>
                            </div>
                      
                        </div>
                      </div>
                    </div>
                    <div class="exp_cat" style="display:none">
                      <div class="home_check">
                        <strong>{{ trans('messages.home.category') }}</strong>
                        <div class="rom_ty" id="content-3">
                         
                            <div class="col-md-12 margin-top-10">
                              <div class="row">
                                <div class="holecheck">
                                  <div class="">
                                    <input type="checkbox" id="cat-type-" value="" class="head_cat_type"  />
                                    <label class="search_check_label" for="cat-type-"></label>
                                  </div>
                                </div>
                              </div>
                            </div>
                           
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="panel-new-body">
                    <button type="submit" class="btn btn-primary btn-block">
                      <i class="icon icon-search"></i>
                      <span>{{ trans('messages.header.find_place') }}</span>
                    </button>
                  </div>
                </div>
              </form>
            </li>
            <li class="dropdown-trigger pull-left large-right-margin hide-sm hide" data-behavior="recently-viewed__container">
              <a class="no-crawl link-reset" href="{{ url('/') }}/login?_ga=1.237472128.1006317855.1436675116#" data-href="/history#docked-filters" data-behavior="recently-viewed__trigger">
                <span class="show-lg recently-viewed__label">
                  {{ trans('messages.header.recently_viewed') }}
                </span>
                <span class="hide-lg recently-viewed__label">
                  <i class="icon icon-recently-viewed icon-gray h4"></i>
                </span>
                <i class="icon icon-caret-down icon-light-gray h5"></i>
              </a>
              <div class="tooltip tooltip-top-left dropdown-menu recently-viewed__dropdown" data-behavior="recently-viewed__dropdown">
              </div>
            </li>
          </ul>
        @endif
      @endif
    </div>
    <div class="pull-right resp-zoom">
      @if(!Auth::check())
        <ul class="nav pull-left logged-out list-unstyled">
          <li id="login" class="pull-left font-color">
            <a data-login-modal="" href="{{ url('login') }}" data-redirect="" class="link-reset login_popup_head">
              {{ trans('login') }}
            </a>
          </li>
          <li id="sign_up" class="pull-left font-color">
            <a data-signup-modal="" data-header-view="true" href="{{ url('signup_login') }}" data-redirect="" class="link-reset signup_popup_head">
              signup
            </a>
          </li>
        </ul>
      @endif
      @if(Auth::check())
        <ul class="nav pull-left list-unstyled msg-wish">
          <li id="header-help-menu" class="help-menu-container pull-left dropdown-trigger">
            <a class=" link-reset" href="{{ url('help') }}">
              <span class="help-pos">help</span>
              <i class="help-icon"></i>
            </a>
          </li>
        </ul>
        <ul class="nav pull-left list-unstyled" role="navigation">
          <li id="inbox-item" class="inbox-item pull-left dropdown-trigger js-inbox-comp">
            <a href="{{ url('inbox') }}" rel="nofollow" class="no-crawl link-reset inbox-icon">
              <span class="" style="position:relative;" > {{ trans_choice('messages.dashboard.message', 2) }}
                <i class="alert-count text-center {{ (Auth::user()->inbox_count()) ? '' : 'fade' }}">{{ Auth::user()->inbox_count() }}</i>
              </span>
            </a>
            <div class="tooltip tooltip-top-right dropdown-menu list-unstyled header-dropdown notifications-dropdown hide">
            </div>
            <div class="panel drop-down-menu-msg hide js-become-a-host-dropdown">
              <div class="w-100">
                <div class="panel-header no-border section-header-home" ><strong><span>Messages</span></strong><a href="{{ url('inbox') }}" class="link-reset view-trips pull-right"><span>View Inbox</span></a></div>
                <div class="panel-header no-border section-header-home pull-left" style="width:100%;" ><strong><span>Notifications</span></strong><a href="{{ url('dashboard') }}" class="link-reset view-trips pull-right"><span>View Dashboard</span></strong></a></div>
                
                <div class="pull-left text-center w-100" style="padding:15px 20px;">
                  @if(Auth::user()->inbox_count())
                    <p style="margin:0px;padding-top:10px !important;"> There are {{ Auth::user()->inbox_count() }} notifications waiting for you in your <a style="color:#333;text-decoration:underline;" href="{{ url('dashboard') }}">  {{ trans('messages.header.dashboard') }} </a>.</p>
                  @else
                    <p style="margin:0px;padding-top:10px !important;"> There are no notifications waiting for you in your <a style="color:#333;text-decoration:underline;" href="{{ url('dashboard') }}">  {{ trans('messages.header.dashboard') }} </a>.</p>
                  @endif
                </div>
              </div>
            </div>
          </li>
          <li class="user-item pull-left medium-right-margin dropdown-trigger">
            <a class="link-reset header-avatar-trigger " id="header-avatar-trigger" href="{{ url('login') }}">
              <div class="media-photo media-round user-profile-image" style="background: rgba(0, 0, 0, 0) url({{ Auth::user()->profile_picture->header_src }}) no-repeat scroll 0 0 / cover" ></div>
              <span class="value_name">
                Hi {{ Auth::user()->first_name }}
              </span>
              <i class="caret"></i>
            </a>
            <ul class="tooltip tooltip-top-right dropdown-menu list-unstyled header-dropdown drop-down-menu-login">
              <li>
                <a href="{{ url('dashboard') }}" rel="nofollow" class="no-crawl link-reset menu-item item-dashboard padding-left">
                  {{ trans('messages.header.dashboard') }}
                </a>
              </li>
              <li class="listings">
                <a href="{{ url('rooms') }}" rel="nofollow" class="no-crawl link-reset menu-item item-listing padding-left">
                  <span class="plural">
                    {{ trans_choice('messages.header.your_listing',2) }}
                  </span>
                </a>
              </li>
              <li class="reservations" style="display: none;">
                <a href="{{ url('my_reservations') }}" rel="nofollow" class="no-crawl link-reset menu-item item-reservation padding-left">
                  {{ trans('messages.header.your_reservations') }}
                </a>
              </li>
              <li style="display: none;">
                <a href="{{ url('trips/current') }}" rel="nofollow" class="no-crawl link-reset menu-item item-trips padding-left">
                  {{ trans('messages.header.your_trips') }}
                </a>
              </li>
              @if(Auth::user()->wishlists)
                <li>
                  <a href="{{ url('wishlists/my') }}" id="wishlists" class="no-crawl link-reset menu-item item-wishlists padding-left">
                    {{ trans_choice('messages.header.wishlist',2) }}
                  </a>
                </li>
              @endif
              <li class="groups hide">
                <a href="{{ url('groups') }}" rel="nofollow" class="no-crawl link-reset menu-item item-groups padding-left">
                  {{ trans('messages.header.groups') }}
                </a>
              </li>
              <li>
                <a href="{{ url('users/edit') }}" rel="nofollow" class="no-crawl link-reset menu-item item-user-edit padding-left">
                  {{ trans('messages.header.edit_profile') }}
                </a>
              </li>
              <li>
                <a href="{{ url('users/security') }}" rel="nofollow" class="no-crawl link-reset menu-item item-account padding-left">
                  {{ trans('messages.header.account') }}
                </a>
              </li>
              <li class="business-travel hide">
                <a href="{{ url('business') }}" rel="nofollow" class="no-crawl link-reset menu-item item-business-travel padding-left">
                  {{ trans('messages.header.business_travel') }}
                </a>
              </li>
              <li>
                
                
                <a href="{{ route('impersonate.leave') }}">Leave impersonation</a>
                @else
                  <a href="{{ url('logout') }}" rel="nofollow" class="no-crawl link-reset menu-item header-logout padding-left">
                    <!-- logout -->
                  </a>
                 
              </li>
            </ul>
          </li>
        </ul>
      @endif
      <ul class="nav pull-left help-menu list-unstyled">
        @if(!Auth::check())
          <li id="header-help-menu" class="help-menu-container pull-left dropdown-trigger">
            <a class="link-reset btn_border_none" href="{{ url('help') }}">
              help
            </a>
          </li>
        @endif
        @if(!Auth::check())
          <li id="header-contact-menu" class="contact-menu-container pull-left dropdown-trigger">
            <a class="link-reset btn_border_none" href="{{ url('contact') }}">
              Contact Us
            </a>
          </li>
        @endif
        @if(!Auth::check())
          <li class="list-your-space pull-left rjlistspace">
            <a  class="{{ Auth::check() ? '' : 'login_popup_open' }}" href="{{url('rooms/new')}}" style="border-left:none !important;">
              <span id="list-your-space" class="btn btn-special list-your-space-btn btn_border_none">
                List your Home
              </span>
            </a>
            {{--
			<ul class="become_dropdown " style="display:none">
			  <li>
				<a href="{{ url('rooms/new') }}" rel="nofollow" class="no-crawl link-reset menu-item item-dashboard padding-left">
				  {{ trans('messages.header.head_homes') }}
				</a>
			  </li>
			  <li class="listings">
				<a href="{{ url('host/experiences') }}" rel="nofollow" class="no-crawl link-reset menu-item item-listing padding-left">
				  {{ trans('messages.header.head_experience') }}
				</a>
			  </li>
			</ul>
			--}}
          </li>
        @endif
        @if(Auth::check())
          <li class="list-your-space pull-left rjlistspace">
            <a  class="{{ Auth::check() ? '' : 'login_popup_open' }}" href="{{url('rooms/new')}}" style="border-left:none !important;">
              <span id="list-your-space" class="btn btn-special list-your-space-btn btn_border_none">
                {{ trans('messages.header.list_your_space') }}
              </span>
            </a>
            {{--
			<ul class="become_dropdown" style="display:none">
			  <li>
				<a href="{{ url('rooms/new') }}" rel="nofollow" class="no-crawl link-reset menu-item item-dashboard padding-left">
				  {{ trans('messages.header.head_homes') }}
				</a>
			  </li>
			  <li class="listings">
				<a href="{{ url('host/experiences') }}" rel="nofollow" class="no-crawl link-reset menu-item item-listing padding-left">
				  {{ trans('messages.header.head_experience') }}
				</a>
			  </li>
			</ul>
			--}}
          </li>
        @endif
      </ul>
    </div>
  </header>
</div>
<div class="flash-container">
  @if(Session::has('message') && !isset($exception))
    @if((!Auth::check() || Route::current()->uri() == 'rooms/{id}' || Route::current()->uri() == '{address}/{id}' || Route::current()->uri() == 'payments/book/{id?}'|| Request::segment(1) == 'host' || Request::segment(1) == 'experiences' ))
      <div class="alert {{ Session::get('alert-class') }}" role="alert">
        <a href="#" class="alert-close" data-dismiss="alert"></a>
        {{ Session::get('message') }}
      </div>
    @endif
  @endif
</div>
<script src="{{ url('dist/client/js/business/includes/header.min.js') }}"></script>
{{-- Login modal --}}
