<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Vacation Homes For Rent From Owners &amp; Property Managers | Vacation.Ren...</title>
        <meta name="description" content="Find perfect vacation rentals for your next trip from private owners and property managers. Rent direct with no booking fees, no commissions, no hidden cha...">
        <meta name="keywords" content="vacation, rentals, vacation rentals, property manager, property owner, no fees, commissions, direct communication">
        <meta name="Content-Type" content="text/html; charset=UTF-8">
        <meta name="charset" content="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="mobile-web-app-capable" content="yes">
        <meta property="og:type" content="website">
        <meta property="og:title" content="Vacation.Rentals">
        <meta property="og:description" content="Find perfect vacation rentals for your next trip from private owners and property managers. Rent direct with no booking fees, no commissions, no hidden charges. We make the introduction and leave the rest up to you.">
        <meta property="og:site_name" content="https://www.vacation.rentals">
        <meta property="og:image" content="https://www.vacation.rentalsimages/logo/vr_logo_icon_text.png">
        <meta property="og:locale" content="en_US">
        <meta property="og:profile:username" content="VacationRentals4U">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="@Vacarent">
        <meta name="twitter:title" content="Vacation.Rentals">
        <meta name="twitter:description" content="Find perfect vacation rentals for your next trip from private owners and property managers. Rent direct with no booking fees, no commissions, no hidden charges. We make the introduction and leave the rest up to you.">
        <meta name="twitter:creator" content="@Vacarent">
        <meta name="twitter:url" content="https://www.vacation.rentals">
        <meta name="twitter:image" content="https://www.vacation.rentalsimages/logo/vr_logo_icon_text.png">
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
            <link rel="search" type="application/opensearchdescription+xml" href="#" title="">
          @auth
        <meta name="isLogedin" content="true">
        <meta name="LogedUserId" content="{{ Auth::user()->id }}">
        <meta name="userName" content="{{ Auth::user()->first_name }}">
        <meta name="userFirstName" content="{{ Auth::user()->first_name }}">
        <meta name="userLastName" content="{{ Auth::user()->last_name }}">
        <meta name="userEmail" content="{{ Auth::user()->email }}">
        <meta name="userProfilePic" content="{{ Auth::user()->profile_picture->src }}">
        @endauth
        @guest
        <meta name="isLogedin" content="false">
        <meta name="userName" content="NoUser">
        @endguest
        @if(isset($newUser))
        <meta name="newUser_first_name" content="{{$newUser['first_name']}}">
        <meta name="newUser_last_name" content="{{$newUser['last_name']}}">
        <meta name="newUser_linkedin_id" content="{{$newUser['linkedin_id']}}">
        <meta name="newUser_fb_id" content="{{$newUser['fb_id']}}">
        <meta name="newUser_google_id" content="{{$newUser['google_id']}}">
        <meta name="newUser_avatar_original" content="{{$newUser['avatar_original']}}">
        <meta name="newUser_avatar" content="{{$newUser['avatar']}}">
        <meta name="newUser_email" content="{{$newUser['email']}}">
        @endif
        <!-- Fonts -->
        <link rel="stylesheet" href="https://res.cloudinary.com/vacation-rentals/raw/upload/v1553982674/css/all.css" type="text/css">
        <link rel="stylesheet" href="/css/app.css" type="text/css">
        <link rel="stylesheet" href="https://res.cloudinary.com/vacation-rentals/raw/upload/v1553983307/css/search.css" type="text/css">
    </head>
    <body class="home_view v2 simple-header p1  new_home ng-scope">

        
        <div id="root"></div>
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAhBWoIW7bxeFxqjSdVv2ynC01K9wVVEuo&libraries=places"></script>
        <script src="/js/search/app.js"></script>
        <script>jQuery(document).ready(function(){"use strict";function stickyNav(){var scrollTop=$(window).scrollTop(),noSticky=$('.no-sticky'),viewportSm=$('.viewport-sm'),viewportLg=$('.viewport-lg'),viewportLgBody=viewportLg.parent('body'),viewportLgNosticky=$('.viewport-lg.no-sticky'),viewportLgNostickyBody=viewportLgNosticky.parent('body'),viewportLgLogo=viewportLg.find('.logo img'),viewportLgNostickyLogo=viewportLgNosticky.find('.logo img'),headerTransparentLg=$('.viewport-lg.header-transparent'),headerTransparentLgNosticky=$('.viewport-lg.header-transparent.no-sticky'),headerTransparentLgBody=headerTransparentLg.parent('body'),headerOpacityLg=$('.viewport-lg.header-opacity'),headerOpacityLgNosticky=$('.viewport-lg.header-opacity.no-sticky'),headerOpacityLgBody=headerOpacityLg.parent('body');if(scrollTop>navikHeaderHeight){navikHeader.addClass('sticky');viewportLgLogo.attr('src',stickyLogoSrc);viewportLgNostickyLogo.attr('src',logoSrc);headerTransparentLg.removeClass('header-transparent-on');headerOpacityLg.removeClass('header-opacity-on');headerTransparentLgNosticky.addClass('header-transparent-on');headerOpacityLgNosticky.addClass('header-opacity-on');viewportLgBody.css("margin-top",navikHeaderHeight);viewportLg.css("margin-top",-navikHeaderHeight);}else{navikHeader.removeClass('sticky');viewportLgLogo.attr('src',logoSrc);headerTransparentLg.addClass('header-transparent-on');headerOpacityLg.addClass('header-opacity-on');viewportLgBody.add(viewportLg).css("margin-top","0");}
                noSticky.removeClass('sticky');viewportSm.removeClass('sticky');headerTransparentLg.add(headerTransparentLgBody).add(headerOpacityLg).add(headerOpacityLgBody).add(viewportLgNostickyBody).add(viewportLgNosticky).css("margin-top","0");var logoCenterWidth=$('.logoCenter .logo img').width(),menuCenterOneWidth=$('.center-menu-1 .navik-menu').width(),menuCenterOneListMenu=$('.center-menu-1 .navik-menu > ul'),menuCenterOneListWidth=menuCenterOneWidth-logoCenterWidth;if($(window).width()<1200){menuCenterOneListMenu.outerWidth(menuCenterOneWidth);}else{menuCenterOneListMenu.outerWidth(menuCenterOneListWidth/2);}
                $('.logoCenter').width(logoCenterWidth);}
                function overlayMenuTransition(){var overlayMenuFirst=$('.navik-menu-overlay > ul > li:first-child'),overlayMenuList=$('.navik-menu-overlay > ul > li');overlayMenuFirst.attr('data-delay','0');overlayMenuList.each(function(){var $this=$(this),overlayMenuNext=$this.next('li'),menuDataDelay=$this.attr('data-delay'),menuDataDelayNext=parseInt(menuDataDelay)+parseInt('100');overlayMenuNext.attr('data-delay',menuDataDelayNext);$this.delay(menuDataDelay).queue(function(next){$(this).addClass("menuSlideIn");next();});});}
                if($('.navik-header').length){var navikHeader=$('.navik-header'),navikHeaderHeight=navikHeader.height(),logo=navikHeader.find('.logo'),logoImg=logo.find('img'),logoSrc=logoImg.attr('src'),logoClone=logo.clone(),mobileLogoSrc=logo.data('mobile-logo'),stickyLogoSrc=logo.data('sticky-logo'),burgerMenu=navikHeader.find('.burger-menu'),navikMenuListWrapper=$('.navik-menu > ul'),navikMenuListDropdown=$('.navik-menu ul li:has(ul)'),headerShadow=$('.navik-header.header-shadow'),headerTransparent=$('.navik-header.header-transparent'),headerOpacity=$('.navik-header.header-opacity'),megaMenuFullwidthContainer=$('.mega-menu-fullwidth .mega-menu-container');$('.center-menu-1 .navik-menu > ul:first-child').after('<div class="logoCenter"></div>');$('.logoCenter').html(logoClone);megaMenuFullwidthContainer.each(function(){$(this).children().wrapAll('<div class="mega-menu-fullwidth-container"></div>');});$(window).on("resize",function(){var megaMenuContainer=$('.mega-menu-fullwidth-container');if($(window).width()<1200){logoImg.attr('src',mobileLogoSrc);navikHeader.removeClass('viewport-lg');navikHeader.addClass('viewport-sm');headerTransparent.removeClass('header-transparent-on');headerOpacity.removeClass('header-opacity-on');megaMenuContainer.removeClass('container');}else{logoImg.attr('src',logoSrc);navikHeader.removeClass('viewport-sm');navikHeader.addClass('viewport-lg');headerTransparent.addClass('header-transparent-on');headerOpacity.addClass('header-opacity-on');megaMenuContainer.addClass('container');}
                stickyNav();}).resize();burgerMenu.on("click",function(){$(this).toggleClass('menu-open');navikMenuListWrapper.slideToggle(300);});navikMenuListDropdown.each(function(){$(this).append('<span class="dropdown-plus"></span>');$(this).addClass('dropdown_menu');});$('.dropdown-plus').on("click",function(){$(this).prev('ul').slideToggle(300);$(this).toggleClass('dropdown-open');});$('.dropdown_menu a').append('<span></span>');$(window).on("scroll",function(){stickyNav();}).scroll();var listMenuHover4=$('.navik-menu.menu-hover-4 > ul > li > a');listMenuHover4.append('<div class="hover-transition"></div>');}
                if($('.navik-header-overlay').length){var navikHeaderOverlay=$('.navik-header-overlay'),navikMenuOverlay=$('.navik-menu-overlay'),burgerMenuOverlay=navikHeaderOverlay.find('.burger-menu'),lineMenuOverlay=navikHeaderOverlay.find('.line-menu'),menuOverlayLogo=navikHeaderOverlay.find('.logo'),overlayLogoClone=menuOverlayLogo.clone(),menuWrapperLogoSrc=menuOverlayLogo.data('overlay-logo'),menuOverlayListDropdown=$('.navik-menu-overlay > ul > li:has(ul)'),menuOverlayLink=$('.navik-menu-overlay > ul > li > a'),menuSlide=$('.navik-header-overlay.menu-slide'),menuSlideSubmenuLink=menuSlide.find('.navik-menu-overlay > ul ul a'),menuSlideSubmenuDropdown=menuSlide.find('.navik-menu-overlay > ul > li > ul li:has(ul)'),menuSocialMedia=navikMenuOverlay.next('.menu-social-media'),submenuVerticalListItem=$('.submenu-vertical > ul > li > ul li:has(ul)'),submenuVerticalLink=$('.submenu-vertical > ul > li > ul a');lineMenuOverlay.wrapAll('<span></span>');menuOverlayLink.wrap('<div class="menu-overlay-link"></div>');submenuVerticalLink.wrap('<div class="menu-overlay-link"></div>');menuSlideSubmenuLink.wrap('<div class="menu-overlay-link"></div>');menuOverlayListDropdown.each(function(){var menuOverlayDropdownLink=$(this).children('.menu-overlay-link');menuOverlayDropdownLink.prepend('<span class="overlay-dropdown-plus"></span>');$(this).addClass('overlay_dropdown_menu');});submenuVerticalListItem.each(function(){var submenuVerticalDropdownLink=$(this).children('.menu-overlay-link');submenuVerticalDropdownLink.prepend('<span class="overlay-dropdown-plus"></span>');$(this).addClass('overlay_dropdown_menu');});menuSlideSubmenuDropdown.each(function(){var submenuVerticalDropdownLink=$(this).children('.menu-overlay-link');submenuVerticalDropdownLink.prepend('<span class="overlay-dropdown-plus"></span>');$(this).addClass('overlay_dropdown_menu');});$('.overlay_dropdown_menu > ul').addClass('overlay-submenu-close');$('.overlay-dropdown-plus').on("click",function(){var $thisParent=$(this).parent('.menu-overlay-link');$thisParent.next('ul').slideToggle(300).toggleClass('overlay-submenu-close');$(this).toggleClass('overlay-dropdown-open');});navikMenuOverlay.add(menuSocialMedia).wrapAll('<div class="nav-menu-wrapper"></div>');var overlayNavMenuWrapper=$('.nav-menu-wrapper');overlayNavMenuWrapper.prepend(overlayLogoClone);overlayNavMenuWrapper.find('.logo img').attr('src',menuWrapperLogoSrc);var menuOverlayHover=$('.navik-menu-overlay > ul > .overlay_dropdown_menu > ul');menuOverlayHover.each(function(){$(this).on("mouseenter",function(){$(this).parents("li").addClass("overlay-menu-hover");});$(this).on("mouseleave",function(){$(this).parents("li").removeClass("overlay-menu-hover");});});burgerMenuOverlay.on("click",function(){var overlayMenuList=$('.navik-menu-overlay > ul > li');$(this).toggleClass('menu-open');overlayNavMenuWrapper.toggleClass('overlay-menu-open');overlayMenuList.removeClass("menuSlideIn");if($(this).hasClass("menu-open")){overlayMenuTransition();overlayMenuList.removeClass("menuSlideOut").addClass("menuFade");}
                if(!$(this).hasClass("menu-open")){overlayMenuList.addClass("menuSlideOut").removeClass("menuFade");}});var menuSlideNavWrapper=menuSlide.find('.nav-menu-wrapper'),menuSlideNavLogo=menuSlideNavWrapper.find('.logo');if(navikHeaderOverlay.hasClass('menu-slide')){navikHeaderOverlay.removeClass('overlay-center-menu');}
                menuSlideNavLogo.remove();menuSlideNavWrapper.after('<div class="slidemenu-bg-overlay"></div>');$('.slidemenu-bg-overlay').on("click",function(){menuSlideNavWrapper.removeClass('overlay-menu-open');burgerMenuOverlay.removeClass('menu-open');});}
                if($('.navik-fixed-sidebar').length){var navikFixedSidebar=$('.navik-fixed-sidebar'),navikMenuFixed=$('.navik-menu-fixed'),navikSideContent=$('.navik-side-content'),logoFixedSidebar=navikFixedSidebar.find('.logo'),logoClone=logoFixedSidebar.clone(),burgerMenuFixedSidebar=navikFixedSidebar.find('.burger-menu'),burgerMenuDetach=burgerMenuFixedSidebar.detach(),navikFixedDropdown=navikMenuFixed.find('li:has(ul)');navikFixedSidebar.parent('body').addClass('body-fixed-sidebar');navikFixedSidebar.after('<div class="fixedsidebar-bg-overlay"></div>').after(burgerMenuDetach);navikSideContent.prepend(logoClone);$('.navik-fixed-sidebar .logo, .navik-menu-fixed').wrapAll('<div class="fixed-menu-wrap"></div>');var burgerMenuMove=navikFixedSidebar.next('.burger-menu'),fixedSidebarlineMenu=burgerMenuMove.find('.line-menu');fixedSidebarlineMenu.wrapAll('<span></span>');burgerMenuMove.on("click",function(){$(this).toggleClass('menu-open');navikFixedSidebar.toggleClass('fixed-sidebar-open');});$('.fixedsidebar-bg-overlay').on("click",function(){navikFixedSidebar.removeClass('fixed-sidebar-open');burgerMenuMove.removeClass('menu-open');});navikFixedDropdown.each(function(){$(this).append('<span class="overlay-dropdown-plus"></span>');});$('.overlay-dropdown-plus').on("click",function(){$(this).prev('ul').slideToggle(300).toggleClass('submenu-collapse');$(this).toggleClass('overlay-dropdown-open');});}
                $('.navik-menu-icon').css('color',function(){var iconColorAttr=$(this).data('fa-color');return iconColorAttr;});});</script>
        
    </body>
</html>
