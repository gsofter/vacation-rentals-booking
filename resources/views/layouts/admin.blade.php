<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Admin</title>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
      <meta name="description" content="Phoenixcoded">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="keywords" content=", Flat ui, Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
      <meta name="author" content="Phoenixcoded">
      <link rel="icon" href="{{asset('admin_assets/assets/images/favicon.ico')}}" type="image/x-icon">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">


      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
      <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/css/intlTelInput.css'>

      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/icon/themify-icons/themify-icons.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/icon/icofont/css/icofont.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/pages/flag-icon/flag-icon.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/pages/menu-search/css/component.css')}}">
      <link media="all" type="text/css" href="{{asset('admin_assets/bower_components/chartist/dist/chartist.css')}}">
     
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/pages/flag-icon/flag-icon.min.css')}}">

      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/pages/prism/prism.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/pages/clndr-calendar/css/clndr.css')}}">

      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/bower_components/datedropper/datedropper.min.css')}}" />      
           
      
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/pages/data-table/css/buttons.dataTables.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/pages/data-table/extensions/buttons/css/buttons.dataTables.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/bower_components/select2/dist/css/select2.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/bower_components/switchery/dist/switchery.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/bower_components/summernote/dist/summernote.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/bower_components/spectrum/spectrum.css')}}" />      
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/bower_components/jquery-minicolors/jquery.minicolors.css')}}" /> 
      <link href="{{ asset('admin_assets/plugin/dropify/css/dropify.min.css') }}" rel="stylesheet" >

      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/css/style.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/css/color/color-1.css')}}" id="color" />
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/css/linearicons.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/css/simple-line-icons.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/css/ionicons.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/css/jquery.mCustomScrollbar.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/custom.css')}}">
      
      <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
      
      <script src='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.7/js/intlTelInput.js'></script>

      <script type="text/javascript" src="{{asset('admin_assets/bower_components/tether/dist/js/tether.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/modernizr/modernizr.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/modernizr/feature-detects/css-scrollbars.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/classie/classie.js')}}"></script>
      <script src="{{asset('admin_assets/bower_components/d3/d3.js')}}"></script>
      <script src="{{asset('admin_assets/bower_components/rickshaw/rickshaw.js')}}"></script>
      <script src="{{asset('admin_assets/bower_components/raphael/raphael.min.js')}}"></script>
      <script src="{{asset('admin_assets/bower_components/morris.js/morris.js')}}"></script>    
      
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/moment/min/moment.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/underscore/underscore-min.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/clndr/src/clndr.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/assets/pages/prism/custom-prism.js')}}"></script>
      

      <script type="text/javascript" src="{{asset('admin_assets/bower_components/i18next/i18next.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/jquery-i18next/jquery-i18next.min.js')}}"></script>
     
      
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/chartist/dist/chartist.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/assets/pages/chart/chartlist/js/chartist-plugin-threshold.js')}}"></script>
      
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('admin_assets/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin_assets/assets/pages/data-table/js/jszip.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin_assets/assets/pages/data-table/js/pdfmake.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin_assets/assets/pages/data-table/js/vfs_fonts.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin_assets/assets/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin_assets/assets/pages/data-table/extensions/buttons/js/buttons.flash.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin_assets/assets/pages/data-table/extensions/buttons/js/jszip.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin_assets/assets/pages/data-table/extensions/buttons/js/pdfmake.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin_assets/assets/pages/data-table/extensions/buttons/js/vfs_fonts.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin_assets/assets/pages/data-table/extensions/buttons/js/buttons.colVis.min.js')}}"></script>
    
    <script type="text/javascript" src="{{asset('admin_assets/bower_components/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin_assets/bower_components/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

    <script type="text/javascript" src="{{asset('admin_assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin_assets/bower_components/multiselect/js/jquery.multi-select.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin_assets/bower_components/switchery/dist/switchery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin_assets/bower_components/summernote/dist/summernote.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin_assets/bower_components/spectrum/spectrum.js')}}"></script>    
    <script type="text/javascript" src="{{asset('admin_assets/bower_components/jquery-minicolors/jquery.minicolors.min.js')}}"></script>
    
    <script type="text/javascript" src="{{asset('admin_assets/assets/pages/advance-elements/moment-with-locales.min.js')}}"></script>
    
    <script type="text/javascript" src="{{asset('admin_assets/bower_components/datedropper/datedropper.min.js')}}"></script>
    
    <script type="text/javascript" src="{{asset('admin_assets/plugin/dropify/js/dropify.min.js')}}"></script>
    
    <script type="text/javascript" src="{{asset('admin_assets/assets/js/script.js')}}"></script>
    <script src="{{asset('admin_assets/assets/js/pcoded.min.js')}}"></script>
    <script src="{{asset('admin_assets/assets/js/demo-12.js')}}"></script>
    <script src="{{asset('admin_assets/assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script src="{{asset('admin_assets/assets/js/jquery.mousewheel.min.js')}}"></script>     
   </head>
   <body>
        <div class="theme-loader">
            <div class="ball-scale">
                <div></div>
            </div>
        </div>
        <div id="pcoded" class="pcoded">
            <div class="pcoded-overlay-box"></div>
            <div class="pcoded-container navbar-wrapper">
                <nav class="navbar header-navbar pcoded-header" header-theme="theme4">
                    <div class="navbar-wrapper">
                        <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                        <i class="ti-menu"></i>
                        </a>
                       
                        <a href="index-2.html">
                        <img class="img-fluid" src="{{asset('admin_assets/assets/images/logo.png')}}" alt="Theme-Logo" />
                        </a>
                        <a class="mobile-options">
                        <i class="ti-more"></i>
                        </a>
                        </div>
                        <div class="navbar-container container-fluid">
                        <div>
                            <ul class="nav-left">
                                <li>
                                    <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                                </li>                                
                                <li>
                                    <a href="#!" onclick="javascript:toggleFullScreen()">
                                    <i class="ti-fullscreen"></i>
                                    </a>
                                </li>                                
                            </ul>
                            <ul class="nav-center">
                                <div class='time-frame'>                                   
                                    <span id='time-part'></span>
                                </div>
                            </ul>
                            <ul class="nav-right">
                                <li class="header-notification">
                                    
                                </li>
                               <script>
                                    var interval = setInterval(function() {
                                        var momentNow = moment();                                       
                                        $('#time-part').html(momentNow.format('YYYY MMMM DD') + ' '
                                        + momentNow.format('dddd')
                                         .substring(0,3).toUpperCase()+ ' ' +momentNow.format('A hh:mm:ss'));
                                    }, 100);
                                    
                                    $('#stop-interval').on('click', function() {
                                        clearInterval(interval);
                                    });
                               </script>
                                <li class="user-profile header-notification">
                                    <a href="#!">
                                    <img src="{{asset('admin_assets/assets/images/user.jpg')}}" alt="User-Profile-Image">
                                    <span>{{ Auth::user()->username }}  - Administrator</span>
                                    <i class="ti-angle-down"></i>
                                    </a>
                                    <ul class="show-notification profile-notification">
                                    
                                    <li>

                                        <a href="{{ route('admin.logout') }}" style="width: 100%;"	onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat"> 
                                            <i class="ti-layout-sidebar-left"></i> Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>                                       
                                    </li>
                                    </ul>
                                </li>
                            </ul>                           
                        </div>
                        </div>
                    </div>
                </nav>
                
                <div class="pcoded-main-container">
                    <div class="pcoded-wrapper">           

                    @yield('admin-content')

                    </div>
                </div>
            </div>
        </div>
      
      
   </body>
   
</html>