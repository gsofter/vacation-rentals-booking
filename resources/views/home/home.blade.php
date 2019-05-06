@extends('layouts.main')
@section('main')
	<!-- home.blade.php -->
	<main id="site-content" role="main">
		<div class="hero shift-with-hiw js-hero">
			<div class="hero__background" data-native-currency="ZAR" aria-hidden="true">
				@if($home_page_media == 'Slider')
					<ul class="rslides" id="home_slider">
						@foreach($home_page_sliders as $row)
							<li><img alt="" src="{{ $row->image_url }}" width="100%"></li>
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
						<h3><span class="left_cls">Vacation Rentals From Owners And Property Managers</span><span class="txt-rotate" data-period="2000" data-rotate='[ "No Fees.", "No commissions.", "100% Verified."]'></span></h3>
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
				<div class="hero__content-footer hide-sm show-md show-lg">
					<div class="col-sm-12">
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
								{!! Form::close() !!}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="hide show-md show-lg show-sm">
			<section class="how-it-works how-it-works--overlay resp-how js-how-it-works" aria-hidden="true" style="top: 0px;display:none;height:361px;">
				<a href="javascript:void(0);" class="how-it-works__close panel-close js-close-how-it-works">
					<span class="screen-reader-only">
						{{ trans('messages.home.close') }} {{ trans('messages.home.how_it_works') }}
					</span>
				</a>
				<div class="page-container-responsive panel-contrast text-contrast">
					<h2 class="screen-reader-only">
						{{ trans('messages.home.how_it_works') }}
					</h2>
					<div class="row space-top-8 text-center">
						<div class="how-it-works__step how-it-works__step-one col-md-4">
							<div class="panel-body">
								<div class="how-it-works__image"></div>
								<h3>{{ trans('messages.home.discover_places') }}</h3>
								<p>{{ trans('messages.home.discover_places_desc') }}</p>
							</div>
						</div>
						<div class="how-it-works__step how-it-works__step-two col-md-4">
							<div class="panel-body">
								<div class="how-it-works__image"></div>
								<h3>{{ trans('messages.home.book_stay') }}</h3>
								<p>{{ trans('messages.home.book_stay_desc', ['site_name'=>$site_name]) }}</p>
							</div>
						</div>
						<div class="how-it-works__step how-it-works__step-three col-md-4">
							<div class="panel-body">
								<div class="how-it-works__image"></div>
								<h3>{{ trans('messages.home.travel') }}</h3>
								<p>{{ trans('messages.home.travel_desc') }}</p>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="panel panel-dark pull-left" style="width:100%;border:none !important;">
			<div id="discovery-container">
				<div class="discovery-section hide page-container-responsive page-container-no-padding" id="discovery-saved-searches">
				</div>
				<div class="discovery-section hide page-container-responsive page-container-no-padding" id="weekend-recommendations">
				</div>
				<section class="how_it_works white_bg text-center">
					<div class="page-container-responsive page-container-no-padding">
						<div class="top_text_wrap">
							<h2>How it works </h2>
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
				</section>
				<section class="list_your_space_info text-center">
					<div class="page-container-responsive page-container-no-padding">
						<div class="col-md-12">
							<img src="images/home-icons.png" alt="Vacation Rentals">
							<h4>Communicate with each other directly BEFORE the reservation is made.</h4>
							<p>We just make the introductions and leave the rest to you - the homeowner and  traveler to see if there is a match. We think of ourselves as "The Vacation Matchmaker!"</p>
						</div>
					</div>
				</section>
				<div class="discovery-section white_bg" id="discover-recommendations">
					<div class="page-container-responsive page-container-no-padding">
						@if(count(@$home_city) > 0)
							<div class="section-intro text-center row-space-6 row-space-top-8">
								<h2 class="row-space-1">{{ trans('messages.home.explore_world') }}</h2>
								<p>{{ trans('messages.home.explore_desc') }}</p>
							</div>
						@endif 
						<div class="discovery-tiles">
							<div class="row">
								<div class="col-lg-8 col-md-12 rm-padding-sm">
									<div class="location_des row-space-4">
										<div class="discovery-card rm-padding-sm darken-on-hover " style="background-image:url(https://www.vacation.rentals/images/home_cities/home_city_1523078462.png);">
											<a href="https://www.vacation.rentals/services/homeowners_are_back_in_charge" target="_blank" class="link-reset" data-hook="discovery-card">
												<div class="va-container va-container-v va-container-h">
													<div class="va-middle location_txt text-center text-contrast overlay-dark">
														<div class="h2 mainbanners">
															<strong>Endless support for homeowners </strong>
														</div>
													</div>
													<div class="location_overlay">
													</div>
												</div>
											</a>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-md-6 col-sm-12 rm-padding-sm">
									<div class="location_des row-space-4">
										<div class="discovery-card rm-padding-sm darken-on-hover " style="background-image:url(https://www.vacation.rentals/images/home_cities/home_city_1523016750.jpg);">
											<a href="https://www.vacation.rentals/services/property_managers_can_list_with_us" target="_blank" class="link-reset" data-hook="discovery-card">
												<div class="va-container va-container-v va-container-h">
													<div class="va-middle location_txt text-center text-contrast overlay-dark">
														<div class="h2 mainbanners">
															<strong>We welcome property managers </strong>
														</div>
													</div>
													<div class="location_overlay">
													</div>
												</div>
											</a>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-md-6 col-sm-12 rm-padding-sm">
									<div class="location_des row-space-4">
										<div class="discovery-card rm-padding-sm darken-on-hover " style="background-image:url(https://www.vacation.rentals/images/home_cities/home_city_1523024594.png);">
											<a href="https://www.vacation.rentals/services/how_your_customers_search" target="_blank" class="link-reset" data-hook="discovery-card">
												<div class="va-container va-container-v va-container-h">
													<div class="va-middle location_txt text-center text-contrast overlay-dark">
														<div class="h2 mainbanners">
															<strong>Be found in search engines </strong>
														</div>
													</div>
													<div class="location_overlay">
													</div>
												</div>
											</a>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-md-6 col-sm-12 rm-padding-sm">
									<div class="location_des row-space-4">
										<div class="discovery-card rm-padding-sm darken-on-hover " style="background-image:url(https://www.vacation.rentals/images/home_cities/home_city_1523107824.jpg);">
											<a href="#" class="link-reset" data-hook="discovery-card">
												<div class="va-container va-container-v va-container-h">
													<div class="va-middle location_txt text-center text-contrast overlay-dark">
														<div class="h2 mainbanners">
															<strong>Travelers - No fees or commissions </strong>
														</div>
													</div>
													<div class="location_overlay">
													</div>
												</div>
											</a>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-md-6 col-sm-12 rm-padding-sm">
									<div class="location_des row-space-4">
										<div class="discovery-card rm-padding-sm darken-on-hover " style="background-image:url(https://www.vacation.rentals/images/home_cities/home_city_1523107625.jpg);">
											<a href="https://www.vacation.rentals/features_loaded_from_top_to_bottom" target="_blank" class="link-reset" data-hook="discovery-card">
												<div class="va-container va-container-v va-container-h">
													<div class="va-middle location_txt text-center text-contrast overlay-dark">
														<div class="h2 mainbanners">
															<strong>Loaded from top to bottom </strong>
														</div>
													</div>
													<div class="location_overlay">
													</div>
												</div>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="belong-video-player" class="fullscreen-video-player fullscreen-video-player--hidden" aria-hidden="true">
			<div class="row row-table row-full-height">
				<div class="col-sm-12 col-middle text-center">
					<video preload="none">
						<source src="{{ $home_video }}" type="video/mp4">
					</video>
					<i id="play-button-belong" class="fullscreen-video-player__icon icon icon-video-play icon-white hide"></i>
					<a id="close-fullscreen-belong" class="fullscreen-video-player__close link-reset" href="{{URL::to('/')}}/#">
						<i class="icon icon-remove"></i>
						<span class="screen-reader-only">
							{{ trans('messages.home.exit_full_screen') }}
						</span>
					</a>
				</div>
			</div>
		</div>
		<div id="belo-video-player" class="fullscreen-video-player fullscreen-video-player--hidden" aria-hidden="true">
			<div class="row row-table row-full-height">
				<div class="col-sm-12 col-middle text-center">
					<video preload="none">
						<source src="{{ $home_video }}" type="video/mp4">
					</video>
					<i id="play-button-belo" class="fullscreen-video-player__icon icon icon-video-play icon-white hide"></i>
					<a id="close-fullscreen-belo" class="fullscreen-video-player__close link-reset" href="{{URL::to('/')}}/#">
						<i class="icon icon-remove"></i>
						<span class="screen-reader-only">
							{{ trans('messages.home.exit_full_screen') }}
						</span>
					</a>
				</div>
			</div>
		</div>
		<div class="feel_like_home clearfix text-center">
			<div class="page-container-responsive page-container-no-padding">
				<div class="row">
					<div class="col-lg-4 col-md-6 col-sm-12">
						<div class="vrborder_sec">
							<div class="vc_img_sec">
								<img src="images/vc_rj_1.png" alt="Vacation Rentals">
								<h3>Great Homes</h3>
							</div>
							<p>Find out what it's like to stay at the top of a mountain or right on the beach. Find a private home for rent that has everything you want and more.</p>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-12">
						<div class="vrborder_sec">
							<div class="vc_img_sec">
								<img src="images/vc_rj_3.png" alt="Vacation Rentals">
								<h3>#1. Search Term</h3>
							</div>
							<p>Travelers find homes for rent by searching for the number 1 search term in the world - "Vacation Rentals". Help travelers find yours by listing with us.</p>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-12">
						<div class="vrborder_sec">
							<div class="vc_img_sec">
								<img src="images/vc_rj_6.png" alt="Vacation Rentals">
								<h3>Interact Direct</h3>
							</div>
							<p>We filter nothing. Customers and homeowners are free to interact with each other instantly with no fear of their contact information being scrubbed.</p>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-12">
						<div class="vrborder_sec">
							<div class="vc_img_sec">
								<img src="images/vc_rj_2.png" alt="Vacation Rentals">
								<h3>Verified Listings</h3>
							</div>
							<p>Every home that is listed on our site is verified prior to activation by the site administrator. What you reserve is what you will get. We do not allow "bait and switch" tactics.</p>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-12">
						<div class="vrborder_sec">
							<div class="vc_img_sec">
								<img src="images/vc_rj_5.png" alt="Vacation Rentals">
								<h3>No Commissions</h3>
							</div>
							<p>Homeowners and property managers never need to worry about commissions when listing with us. Ours is a straight forward annual membership and nothing more.</p>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-12">
						<div class="vrborder_sec">
							<div class="vc_img_sec">
								<img src="images/vc_rj_4.png" alt="Vacation Rentals">
								<h3>No Travelers Fees</h3>
							</div>
							<p>We never charge travelers for making a reservation through our site. All expenses are paid by the listing owner with nothing else due. Book with confidence and enjoy your vacation.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="host-section">
			<div class="page-container-responsive page-container-no-padding">
				<div class="row flex-container">
					<div class="col-md-4">
						<div class="host-area cenralize">
							<div class="host-container"><img class="img-responsive" alt="Rent Direct From Owners With No Fees" src="images/direct-deal-3221.jpg"><div class="image-shadow"></div></div>
							<h4 class="stat-text">Deal direct with your host</h4>
							<ul class="host-list">
								<li>Open, unfiltered communication</li>
								<li>Phone - email - even Live Chat</li>
								<li>Build trust before you book</li>
							</ul>
						</div>
					</div>
					<div class="col-md-4">
						<div class="host-area cenralize">
							<div class="host-container"><img class="img-responsive" alt="Rent Direct From Owners With No Fees" src="images/Multiple_listing_titles11.jpg"><div class="image-shadow"></div></div>
							<h4 class="stat-text">Why list your home with us?</h4>
							<ul class="host-list">
								<li>Advertising and exposure</li>
								<li>A simple annual membership and nothing more</li>
								<li>Reach more prospective clients</li>
							</ul>
						</div>
					</div>
					<div class="col-md-4">
						<div class="host-area cenralize">
							<div class="host-container"><img class="img-responsive" alt="Rent Direct From Owners With No Fees" src="images/list-vacation1.jpg"><div class="image-shadow"></div></div>
							<h4 class="stat-text">List your vacation rental</h4>
							<ul class="host-list">
								<li>It only takes minutes</li>
								<li>Easy calendar, rates, and gallery</li>
								<li>Immediate exposure</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="{{ url('dist/client/js/business/includes/home.min.js') }}"></script>

	<script>
		var placeSearch,autocomplete,TxtRotate=function(e,t,o){this.toRotate=t,this.el=e,this.loopNum=0,this.period=parseInt(o,10)||2e3,this.txt="",this.tick(),this.isDeleting=!1};TxtRotate.prototype.tick=function(){var e=this.loopNum%this.toRotate.length,t=this.toRotate[e];this.isDeleting?this.txt=t.substring(0,this.txt.length-this.txt.length):this.txt=t.substring(0,this.txt.length+1),this.el.innerHTML='<span class="wrap">'+this.txt+"</span>";var o=this,i=300-100*Math.random();this.isDeleting&&(i/=2),this.isDeleting||this.txt!==t?this.isDeleting&&""===this.txt&&(this.isDeleting=!1,this.loopNum++,i=500):(i=this.period,this.isDeleting=!0),setTimeout(function(){o.tick()},i)},window.onload=function(){for(var e=document.getElementsByClassName("txt-rotate"),t=0;t<e.length;t++){var o=e[t].getAttribute("data-rotate"),i=e[t].getAttribute("data-period");o&&new TxtRotate(e[t],JSON.parse(o),i)}
		var a=document.createElement("style");a.type="text/css",a.innerHTML=".txt-rotate > .wrap { border-right: 0.08em solid #666 }",document.body.appendChild(a)}
	</script>
@stop
