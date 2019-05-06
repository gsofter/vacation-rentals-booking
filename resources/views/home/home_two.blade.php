<?php

/**
 * home_new.blade.php
 *
 * @description
 *
 * @author  Eddie Padin
 *
 * @project vacationrentals
 */
?>

@extends('layouts.main')
@section('content')
	<main id="site-content" role="main">
		<div class="hero shift-with-hiw js-hero">
			<div class="hero__background" data-native-currency="ZAR" aria-hidden="true">
				@if($home_page_media == 'Slider')
					<ul class="rslides" id="home_slider">
						@foreach($home_page_sliders as $row)
							<li class="slider-image"><img alt="" src="{{ $row->image_url }}" width="100%"></li>
						@endforeach
					</ul>
				@elseif($home_page_media == 'Video')
					<video autoplay loop="loop" id="pretzel-video" class="video-playing">
						@if($browser != 'chrome')
							<source src="{{ $home_video }}" id="mp4" type="video/mp4">
						@endif
						<source src="{{ $home_video_webm }}" id="webm" type="video/webm">
					</video>
				@endif
			</div>
			<div class="hero__content page-container page-container-full text-center" style="padding:0px !important;">
				<div class="va-container va-container-v va-container-h">
					<div class="rjbanercont">
						<h3>
							<span class="left_cls white">Vacation Rentals From Owners And Property Managers</span>
							<div class="hero-sub-text mt-15 white shadow-text d-flex justify-content-center">
								<div class="text-container">
									<div class="animated fadeIn mr-20 d-inline-block delay-4s slower">No Fees.</div>
									<div class="animated zoomIn slower d-inline-block">No Commissions.</div>
									<div class="animated fadeIn ml-20 d-inline-block delay-4s slower">100% Verified.</div>
								</div>
							</div>
							{{--<span class="txt-rotate white" data-period="5000" data-rotate='[ "No Fees. No commissions. 100% Verified."]'></span>--}}
						</h3>
					</div>
					<div class="va-middle">
						<div class="back-black">
							<div class="show-sm hide-md sm-search">
								<form id="simple-search" class="simple-search hide js-p1-simple-search">
									<div class="alert alert-with-icon alert-error  hide space-2 js-search-error"><i class="icon alert-icon icon-alert-alt"></i>
										{{ trans('messages.home.search_validation') }}
									</div>
									<label for="simple-search-location" class="screen-reader-only">
										{{ trans('messages.home.where_do_you_go') }}
									</label>
									<input type="text" placeholder="{{ trans('messages.home.where_do_you_go') }}" autocomplete="off" name="locations" id="simple-search-location" class="input-large js-search-location">
									<div class="row row-condensed space-top-2 space-2">
										<div class="col-sm-6">
											<label for="simple-search-checkin" class="screen-reader-only">
												{{ trans('messages.home.checkin') }}
											</label>
											<input id="simple-search-checkin" type="text" name="checkin" class="input-large checkin js-search-checkin" placeholder="{{ trans('messages.home.checkin') }}">
										</div>
										<div class="col-sm-6">
											<label for="simple-search-checkout" class="screen-reader-only">
												{{ trans('messages.home.checkout') }}
											</label>
											<input id="simple-search-checkout" type="text" name="checkout" class="input-large checkout js-search-checkout" placeholder=" {{ trans('messages.home.checkout') }}">
										</div>
									</div>
									<div class="select select-block space-2">
										<label for="simple-search-guests" class="screen-reader-only">
											{{ trans('messages.home.no_of_guests') }}
										</label>
										<select id="simple-search-guests" name="guests" class="js-search-guests">
											@for($i=1;$i<=30;$i++)
												<option value="{{ $i }}"> {{ ($i == '30') ? $i.'+ '.trans_choice('messages.home.guest',$i) : $i.' '.trans_choice('messages.home.guest',$i) }} </option>
											@endfor
										</select>
									</div>
									<button type="submit" class="btn btn-primary btn-large btn-block">
										{{ trans('messages.home.no_of_guest') }}
									</button>
								</form>
								<div class="input-addon js-p1-search-cta" id="sm-search-field">
									<span class="input-stem input-large fake-search-field">
										{{ trans('messages.home.where_do_you_go') }}
									</span>
									<i class="input-suffix btn btn-primary icon icon-full icon-search"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="hero__content-footer hide-sm d-md-flex justify-content-center">
					<div class="col-sm-8">
						<div id="searchbar">
							<div class="searchbar rjsearchbar" data-reactid=".1">
								<form action="{{ url('s') }}" class="simple-search clearfix" method="get" id="searchbar-form" name="simple-search">
									<div class="saved-search-wrapper searchbar__input-wrapper">
										<label class="input-placeholder-group searchbar__location">
											<span class="input-placeholder-label screen-reader-only">{{ trans('messages.home.where_do_you_go') }}</span>
											<input class="menu-autocomplete-input text-truncate form-inline location input-large input-contrast" placeholder="{{ trans('messages.home.where_do_you_go') }}" type="text" name="locations" id="location" aria-autocomplete="both" autocomplete="off" value="">
										</label>
										<div class="searchbar__location-error hide">{{ trans('messages.home.search_validation') }}</div>
										<label class="input-placeholder-group searchbar__checkin">
											<span class="input-placeholder-label screen-reader-only">{{ trans('messages.home.checkin') }}</span>
											<input type="text" readonly="readonly" onfocus="this.blur()" id="checkin" class="checkin text-truncate input-large input-contrast ui-datepicker-target" placeholder="{{ trans('messages.home.checkin') }}">
											<input type="hidden" name="checkin">
										</label>
										<label class="input-placeholder-group searchbar__checkout">
											<span class="input-placeholder-label screen-reader-only">{{ trans('messages.home.checkout') }}</span>
											<input type="text" id="checkout" onfocus="this.blur()" readonly="readonly" class="checkout input-large text-truncate input-contrast ui-datepicker-target" placeholder="{{ trans('messages.home.checkout') }}">
											<input type="hidden" name="checkout">
										</label>
										<label class="searchbar__guests">
											<span class="screen-reader-only">{{ trans('messages.home.no_of_guests') }}</span>
											<div class="select select-large">
												<select id="guests" name="guests">
													@for($i=1;$i<=30;$i++)
														<option value="{{ $i }}"> {{ ($i == '30') ? $i.'+ '.trans_choice('messages.home.guest',$i) : $i.' '.trans_choice('messages.home.guest',$i) }} </option>
													@endfor
												</select>
											</div>
										</label>
										<div id="autocomplete-menu-sbea76915" aria-expanded="false" class="menu hide" aria-role="listbox">
											<div class="menu-section">
											</div>
										</div>
									</div>
									<input type="hidden" name="source" value="bb">
									<button id="submit_location" type="submit" class="searchbar__submit btn btn-primary btn-large">{{ trans('messages.home.search') }}</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			@include('components.ui_elements.masks', ['style' => '4'])
		</div>
		<section class="how_it_works white_bg text-center mb-0 pt-70 pb-70 ">
			
			<div class="page-container-responsive page-container-no-padding">
				<div class="top_text_wrap">
					<div class="section-intro">
						<h2>How it works </h2>
					</div>
					<div class="how_it_sect col-lg-3 col-md-6 col-sm-12">
						<img src="images/how12.png" alt="Vacation Rentals">
						<h3>Search</h3>
						<p>Search for the perfect vacation home for rent from our verified listings</p>
					</div>
					<div class="how_it_sect col-lg-3 col-md-6 col-sm-12">
						<img src="images/how22.png" alt="Vacation Rentals">
						<h3>Make an inquiry</h3>
						<p>Contact the owner or property manager directly</p>
					</div>
					<div class="how_it_sect col-lg-3 col-md-6 col-sm-12">
						<img src="images/rightclick1.png" alt="Vacation Rentals">
						<h3>Make the booking</h3>
						<p>Once you have settled on the home of your choice, book direct with the homeowner or property manager</p>
					</div>
					<div class="how_it_sect col-lg-3 col-md-6 col-sm-12">
						<img src="images/how42.png" alt="Vacation Rentals">
						<h3>Review your stay</h3>
						<p>Tell others about the great trip you had and place you stayed</p>
					</div>
				</div>
			</div>
			@include('components.ui_elements.masks', ['style' => '2'])
		</section>
		<!-- Media Container - Border Animation Style 2 -->
		<section class="hg_section--relative py-0 ">
			<div class="full_width ">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<!-- media-container -->
						<div class="media-container style2 hsize-400 d-flex align-items-start align-items-lg-center justify-content-center">
							<!-- bg source -->
							<div class="kl-bg-source">
								<div class="kl-bg-source__bgimage" style="background-image:url({{ asset('images/vacation_2.jpg') }});background-repeat:no-repeat;background-attachment:scroll;background-position-x:center;background-position-y:75%;background-size:cover"></div>
								<div class="kl-bg-source__overlay" style="background-color:rgba(0,0,0,0.25)"></div>
								<div class="kl-bg-source__overlay-gloss"></div>
							</div>
							<!--/ bg-source -->
							
							<!-- media-container button -->
							<div class="media-container__link media-container__link--btn media-container__link--style-borderanim2 py-2 d-flex flex-column justify-content-center">
								<div class="row">
									<div class="borderanim2-svg text-center mx-auto">
										<svg height="140" width="140" xmlns="http://www.w3.org/2000/svg">
											<rect class="borderanim2-svg__shape" x="0" y="0" height="140" width="140"></rect>
										</svg>
										<span class="media-container__text"><a href="javascript:void(0)" class="signup_popup_head2" title="Register"><img src="{{ asset('images/vr-icon-white.png') }}" class="img-fluid media-container-icon" alt="Vacation Rentals"> </a></span>
									</div>
								</div>
								<div class="row">
									<div class="col-10 col-md-12 float-none mx-auto">
										<div class="text-center pt-1 pt-md-4">
											<h2 class="tbk__title kl-font-alt fs-xs-xl fs-l fw-bold white shadow-text ">
												Communicate directly with each other <span class="tcolor-ext">BEFORE</span> the reservation is made.
											</h2>
											<p class="white mt-2">
												<span class="d-block fs-xs-md fs-22">We think of ourselves as "The Vacation Matchmaker!"</span>
												<span class="d-block mt-1 fs-xs-small fs-18">We just make the introductions and leave the rest to you - the homeowner and  traveler.</span>
											</p>
										</div>
									</div>
								</div>
							</div>
							<!--/ media-container button -->
						</div>
						<!--/ media-container -->
					</div>
					<!--/ col-md-12 col-sm-12  -->
				</div>
				<!--/ row -->
			</div>
			@include('components.ui_elements.masks', ['style' => '3', 'svg_class' => 'svgmask-left'])
		</section>
		<!--/ full_width -->
		<!-- Featured Listings new style 2 element section with custom paddings -->
		<section class="discovery-section white_bg hg_section pt-60 pb-100" id="discover-recommendations">
			<div class="page-container-responsive page-container-no-padding">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-md-12">
							@include('components.listing_widget.listing_slider', ['type' => '1'])
						</div>
						<!--/ col-sm-12 col-md-12 -->
					</div>
					<!--/ row -->
				</div>
				<!--/ container -->
			</div>
			@include('components.ui_elements.masks', ['style' => '1'])
		</section>
		<section class="hg_section--relative pt-0 pb-45 mb-0">
			<div class="page-container-responsive page-container-no-padding pt-0 pb-80">
				<div class="container">
					<div class="row">
						<div class="col-12 col-sm-12">
							<div class="section-intro text-center row-space-6 row-space-top-8">
								<h2 class="row-space-1 tcolor fw-bold">{{ trans('messages.home.explore_world') }}</h2>
								<p>{{ trans('messages.home.explore_desc') }}</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12 col-sm-12 col-md-12">
							<!-- Grid icon box element 3 cols lined boxed style -->
							<div class="grid-ibx grid-ibx--cols-3 grid-ibx--style-lined-full grid-ibx--hover-shadow">
								<div class="grid-ibx__inner">
									<div class="grid-ibx__row clearfix d-flex flex-column flex-md-row">
										<!-- Item - height 300px -->
										<div class="grid-ibx__item h-300">
											<div class="grid-ibx__item-inner">
												<!-- Title wrapper -->
												<div class="grid-ibx__title-wrp">
													<!-- Title with custom font and size -->
													<h4 class="grid-ibx__title kl-font-alt fs-m">
														GREAT HOMES
													</h4>
													<!--/ Title with custom font and size -->
												</div>
												<!--/ Title wrapper -->
												
												<!-- Icon/Image wrapper -->
												<div class="grid-ibx__icon-wrp">
													<!-- Icon = .icon-gi-ico-4 with custom size -->
													{{--<span class="grid-ibx__icon icon-gi-ico-4 fs-xxxl"></span>--}}
													<img src="{{asset('images/vc_rj_1.png')}}" alt="Great homes to rent for vacation">
												</div>
												<!--/ Icon/Image wrapper -->
												
												<!-- Content wrapper -->
												<div class="grid-ibx__desc-wrp">
													<!-- Description -->
													<p class="grid-ibx__desc fs-16">
														Find out what it's like to stay at the top of a mountain or right on the beach. <a href="{{ url('united-states') }}" title="Find a private home for rent for your next vacation">Find a private home for rent</a> that has everything you want and more.
													</p>
													<!--/ Description -->
												</div>
												<!--/ Content wrapper -->
											</div>
											<!--/ .grid-ibx__item-inner -->
										</div>
										<!--/ Item - height 300px - .grid-ibx__item -->
										
										<!-- Item - height 300px -->
										<div class="grid-ibx__item h-300">
											<div class="grid-ibx__item-inner">
												<!-- Title wrapper -->
												<div class="grid-ibx__title-wrp">
													<!-- Title with custom font and size -->
													<h4 class="grid-ibx__title kl-font-alt fs-m">
														#1 SEARCH TERM
													</h4>
													<!--/ Title with custom font and size -->
												</div>
												<!--/ Title wrapper -->
												
												<!-- Icon/Image wrapper -->
												<div class="grid-ibx__icon-wrp">
													<!-- Icon = .icon-gi-ico-1 with custom size -->
													{{--<span class="grid-ibx__icon icon-gi-ico-1 fs-xxxl"></span>--}}
													<img src="{{asset('images/vc_rj_3.png')}}" alt="#1 search term">
												</div>
												<!--/ Icon/Image wrapper -->
												
												<!-- Content wrapper -->
												<div class="grid-ibx__desc-wrp">
													<!-- Description -->
													<p class="grid-ibx__desc fs-16">
														Travelers find homes for rent by searching for the number 1 search term in the world - "Vacation Rentals". Help travelers find yours by listing with us.
													</p>
													<!--/ Description -->
												</div>
												<!--/ Content wrapper -->
											</div>
											<!--/ .grid-ibx__item-inner -->
										</div>
										<!--/ Item - height 300px - .grid-ibx__item -->
										
										<!-- Item - height 300px -->
										<div class="grid-ibx__item h-300">
											<div class="grid-ibx__item-inner">
												<!-- Title wrapper -->
												<div class="grid-ibx__title-wrp">
													<!-- Title with custom font and size -->
													<h4 class="grid-ibx__title kl-font-alt fs-m">
														INTERACT DIRECT
													</h4>
													<!--/ Title with custom font and size -->
												</div>
												<!--/ Title wrapper -->
												
												<!-- Icon/Image wrapper -->
												<div class="grid-ibx__icon-wrp">
													<!-- Icon = .icon-process2 with custom size -->
													{{--<span class="grid-ibx__icon icon-process2 fs-xxxl"></span>--}}
													<img src="{{asset('images/vc_rj_6.png')}}" alt="Interact directly with guests">
												</div>
												<!--/ Icon/Image wrapper -->
												
												<!-- Content wrapper -->
												<div class="grid-ibx__desc-wrp">
													<!-- Description -->
													<p class="grid-ibx__desc fs-16">
														We filter nothing. Customers and homeowners are free to interact with each other instantly with no fear of their contact information being scrubbed.
													</p>
													<!--/ Description -->
												</div>
												<!--/ Content wrapper -->
											</div>
											<!--/ .grid-ibx__item-inner -->
										</div>
										<!--/ Item - height 300px - .grid-ibx__item -->
									</div>
									<!--/ .grid-ibx__row -->
									
									<div class="grid-ibx__row clearfix d-flex flex-column flex-md-row">
										<!-- Item - height 300px -->
										<div class="grid-ibx__item h-300">
											<div class="grid-ibx__item-inner">
												<!-- Title wrapper -->
												<div class="grid-ibx__title-wrp">
													<!-- Title with custom font and size -->
													<h4 class="grid-ibx__title kl-font-alt fs-m">
														VERIFIED LISTINGS</h4>
												</div>
												<!--/ Title wrapper -->
												
												<!-- Icon/Image wrapper -->
												<div class="grid-ibx__icon-wrp">
													<!-- Icon = .icon-process3 with custom size -->
													{{--<span class="grid-ibx__icon icon-process3 fs-xxxl"></span>--}}
													<img src="{{ asset('images/vc_rj_2.png') }}" alt="Verified listings">
												</div>
												<!--/ Icon/Image wrapper -->
												
												<!-- Content wrapper -->
												<div class="grid-ibx__desc-wrp">
													<!-- Description -->
													<p class="grid-ibx__desc fs-16">
														Every home that is listed on our site is verified prior to activation by the site administrator. What you reserve is what you will get. We do not allow "bait and switch" tactics.
													</p>
													<!--/ Description -->
												</div>
												<!--/ Content wrapper -->
											</div>
											<!--/ .grid-ibx__item-inner -->
										</div>
										<!--/ Item - height 300px - .grid-ibx__item -->
										
										<!-- Item - height 300px -->
										<div class="grid-ibx__item h-300">
											<div class="grid-ibx__item-inner">
												<!-- Title wrapper -->
												<div class="grid-ibx__title-wrp">
													<!-- Title with custom font and size -->
													<h4 class="grid-ibx__title kl-font-alt fs-m">
														NO COMMISSIONS
													</h4>
													<!--/ Title with custom font and size -->
												</div>
												<!--/ Title wrapper -->
												
												<!-- Icon/Image wrapper -->
												<div class="grid-ibx__icon-wrp">
													<!-- Icon = .icon-gi-ico-14 with custom size -->
													{{--<span class="grid-ibx__icon icon-gi-ico-14 fs-xxxl"></span>--}}
													<img src="{{asset('images/vc_rj_5.png')}}" alt="No commissions">
												</div>
												<!--/ Icon/Image wrapper -->
												
												<!-- Content wrapper -->
												<div class="grid-ibx__desc-wrp">
													<!-- Description -->
													<p class="grid-ibx__desc fs-16">
														Homeowners and property managers never need to worry about commissions when listing with us. Ours is a straight forward annual membership and nothing more.
													</p>
													<!--/ Description -->
												</div>
												<!--/ Content wrapper -->
											</div>
											<!--/ .grid-ibx__item-inner -->
										</div>
										<!--/ Item - height 300px - .grid-ibx__item -->
										
										<!-- Item - height 300px -->
										<div class="grid-ibx__item h-300">
											<div class="grid-ibx__item-inner">
												<!-- Title wrapper -->
												<div class="grid-ibx__title-wrp">
													<!-- Title with custom font and size -->
													<h4 class="grid-ibx__title kl-font-alt fs-m">
														NO TRAVERLERS FEES
													</h4>
												</div>
												<!--/ Title wrapper -->
												
												<!-- Icon/Image wrapper -->
												<div class="grid-ibx__icon-wrp">
													<!-- Icon = .icon-gi-ico-12 with custom size -->
													{{--<span class="grid-ibx__icon icon-gi-ico-12 fs-xxxl"></span>--}}
													<img src="{{asset('images/vc_rj_4.png')}}" alt="No travelers fees">
												</div>
												<!--/ Icon/Image wrapper -->
												
												<!-- Content -->
												<div class="grid-ibx__desc-wrp">
													<!-- Description -->
													<p class="grid-ibx__desc fs-16">
														We never charge travelers for making a reservation through our site. All expenses are paid by the listing owner with nothing else due. <span class="d-block"><a href="{{ url('united-states') }}" title="Book with confidence and enjoy your vacation.">Book with confidence and enjoy your vacation.</a></span>
													</p>
													<!--/ Description -->
												</div>
												<!--/ Content -->
											</div>
											<!--/ .grid-ibx__item-inner -->
										</div>
										<!--/ Item - height 300px - .grid-ibx__item -->
									</div>
									<!--/ .grid-ibx__row -->
								</div>
								<!--/ grid-ibx__inner -->
							</div>
							<!--/ Grid icon box element 3 cols lined boxed style .grid-ibx -->
						</div>
					</div>
					<!--/ row -->
				</div>
				<!--/ container -->
			</div>
			<!--/ Grid icon box element 3 cols lined style - boxed section white with custom paddings -->
			@include('components.ui_elements.masks', ['style' => '2'])
		</section>
		
		<!-- Action box element style 1 arrow center -->
		<div class="action_box style1 mb-80" data-arrowpos="center">
			<div class="action_box_inner container ">
				<div class="page-container-no-padding action_box_content row d-flex-lg align-content-center">
					<!-- Content -->
					<div class="ac-content-text col-sm-12 col-md-12 col-lg-9 mb-md-20">
						<!-- Title -->
						<h4 class="text text-center text-md-left ">
							Ready to join the hundreds of homeowners and property managers listing on <span class="fw-bold">Vacation.Rentals?</span>
						</h4>
					</div>
					<!--/ Content col-sm-12 col-md-12 col-lg-7 mb-md-20 -->
					
					<!-- Call to Action buttons -->
					<div class="ac-buttons col-sm-12 col-md-12 col-lg-3 d-flex align-self-center justify-content-center justify-content-lg-end">
						@if(Auth::user())
							<a href="{{ route('rooms.new_room') }}" class="btn-lined btn-lg ac-btn w-100 text-center" title="List your property with Vacation.Rentals">
								Get Started!
							</a>
						@else
							<a href="javascript:void(0)" class="signup_popup_head2 btn-lined btn-lg ac-btn w-100 text-center" title="List your property with Vacation.Rentals">
								Get Started!
							</a>
						@endif
					</div>
					<!--/ Call to Action buttons -->
				</div>
				<!--/ .action_box_content -->
			</div>
			<!--/ .action_box_inner -->
		</div>
		<!--/ Action box element style 1 .action_box -->
		
		<section class="host-section">
			<div class="page-container-responsive page-container-no-padding">
				<div class="row flex-container">
					<div class="col-md-4">
						<a href="{{ url('about-us','no-fees-for-travelers-for-any-property-we-list') }}">
							<div class="host-area cenralize">
								<div class="host-container h-260">
									<img class="h-100" title="Rent Direct From Owners With No Fees" alt="Rent Direct From Owners With No Fees" src="{{asset('images/booking_1.jpg')}}">
									<div class="image-shadow"></div>
								</div>
								<h4 class="stat-text">Deal direct with your host</h4>
								<ul class="host-list">
									<li>Open, unfiltered communication</li>
									<li>Phone - email - even Live Chat</li>
									<li>Build trust before you book</li>
								</ul>
							</div>
						</a>
					</div>
					<div class="col-md-4">
						<a href="{{ url('about-us','why-host') }}">
							<div class="host-area cenralize">
								<div class="host-container h-260">
									<img class="h-100" title="Generate more reservations and bookings for your vacation rental property" alt="Generate more reservations and bookings for your vacation rental property" src="{{asset('images/booking_2.jpeg')}}">
									<div class="image-shadow"></div>
								</div>
								<h4 class="stat-text">Why list your home with us?</h4>
								<ul class="host-list">
									<li>Advertising and exposure</li>
									<li>A simple annual membership and nothing more</li>
									<li>Reach more prospective clients</li>
								</ul>
							</div>
						</a>
					</div>
					<div class="col-md-4">
						<a href="{{ route('rooms.new_room') }}" class="login_popup_open">
							<div class="host-area cenralize">
								<div class="host-container h-260">
									<img class="img-responsive" title="Registering on www.vacation.rentals is fast and easy." alt="Registering on www.vacation.rentals is fast and easy." src="{{asset('images/list-vacation1.jpg')}}">
									<div class="image-shadow"></div>
								</div>
								<h4 class="stat-text">List your vacation rental</h4>
								<ul class="host-list">
									<li>It only takes minutes</li>
									<li>Easy calendar, rates, and gallery</li>
									<li>Immediate exposure</li>
								</ul>
							</div>
						</a>
					</div>
				</div>
			</div>
		</section>
	</main>
	@push('scripts')
		<script src="{{ url('dist/client/js/business/includes/home_two.min.js') }}"></script>
	@endpush
@stop
