<nav class="pcoded-navbar" pcoded-header-position="relative">
        <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
        <div class="pcoded-inner-navbar main-menu">           

           <ul class="pcoded-item pcoded-left-item">
              
              <li  class="{{ (Route::is('admin.dashboard') ? 'active' : '') }}">
                        <a href="{{route('admin.dashboard')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-dashboard"></i></span>
                        <span class="pcoded-mtext">Dashboard</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>

              <li class="pcoded-hasmenu {{ ((Route::is('admin.admin.users') || Route::is('admin.admin.roles')) ? 'active' : '' ) }}">
                 <a href="javascript:void(0)" data-i18n="nav.navigate.main">
                 <span class="pcoded-micon"><i class="icofont icofont-ui-user"></i></span>
                 <span class="pcoded-mtext">Manage Admin</span>
                 <span class="pcoded-mcaret"></span>
                 </a>
                 <ul class="pcoded-submenu">
                    <li class=" ">
                       <a href="{{route('admin.admin.users')}}" data-i18n="nav.navigate.navbar">
                       <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                       <span class="pcoded-mtext">Admin Users</span>
                       <span class="pcoded-mcaret"></span>
                       </a>
                    </li>
                    <li class=" "> 
                       <a href="{{route('admin.admin.roles')}}" data-i18n="nav.navigate.navbar-inverse">
                       <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                       <span class="pcoded-mtext">Roles & Permissions</span>
                       <span class="pcoded-mcaret"></span>
                       </a>
                    </li>                    
                 </ul>
                </li>
               <li  class="{{ (Route::is('admin.users') ? 'active' : '') }}">
                        <a href="{{route('admin.users')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-ui-user-group"></i></span>
                        <span class="pcoded-mtext">Manage Users</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>              
                <li class="pcoded-hasmenu {{ ((Route::is('admin.rooms') || Route::is('admin.rooms_tags')) ? 'active' : '' ) }}">
                        <a href="javascript:void(0)" data-i18n="nav.navigate.main">
                        <span class="pcoded-micon"><i class="ti-home"></i></span>
                        <span class="pcoded-mtext">Manage Properties</span>
                        <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                                <li class=" ">
                                <a href="{{route('admin.rooms')}}" data-i18n="nav.navigate.navbar">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Manage Property</span>
                                <span class="pcoded-mcaret"></span>
                                </a>
                                </li>
                                <li class=" "> 
                                <a href="{{route('admin.rooms_tags')}}" data-i18n="nav.navigate.navbar-inverse">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Manage Property Tags</span>
                                <span class="pcoded-mcaret"></span>
                                </a>
                                </li>                    
                        </ul>
                </li>
                <li  class="{{ (Route::is('admin.reservations') ? 'active' : '') }}">
                        <a href="{{route('admin.reservations')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-ui-flight"></i></i></span>
                        <span class="pcoded-mtext">Reservations</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>
                <li class="pcoded-hasmenu {{ ((Route::is('admin.send_email') || Route::is('admin.email_settings')) ? 'active' : '' ) }}">
                        <a href="javascript:void(0)" data-i18n="nav.navigate.main">
                        <span class="pcoded-micon"><i class="icofont icofont-email"></i></i></span>
                        <span class="pcoded-mtext">Manage Email</span>
                        <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                                <li class=" ">
                                <a href="{{route('admin.send_email')}}" data-i18n="nav.navigate.navbar">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Send Email</span>
                                <span class="pcoded-mcaret"></span>
                                </a>
                                </li>
                                <li class=" "> 
                                <a href="{{route('admin.email_settings')}}" data-i18n="nav.navigate.navbar-inverse">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Email Settings</span>
                                <span class="pcoded-mcaret"></span>
                                </a>
                                </li>                    
                        </ul>
                </li>
                <li  class="{{ (Route::is('admin.reviews') ? 'active' : '') }}">
                        <a href="{{route('admin.reviews')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-eye-alt"></i></span>
                        <span class="pcoded-mtext">Reviews</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>              
                <li  class="{{ (Route::is('admin.referrals') ? 'active' : '') }}">
                        <a href="{{route('admin.referrals')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-id-card"></i></span>
                        <span class="pcoded-mtext">Referrals</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>              
                <li  class="{{ (Route::is('admin.wishlists') ? 'active' : '') }}">
                        <a href="{{route('admin.wishlists')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-heart-alt"></i></span>
                        <span class="pcoded-mtext">Wishlists</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>              
                <li  class="{{ (Route::is('admin.coupon') ? 'active' : '') }}">
                        <a href="{{route('admin.coupon')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-price"></i></span>
                        <span class="pcoded-mtext">Manage Coupon Code</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>
                <li  class="{{ (Route::is('admin.reports') ? 'active' : '') }}">
                        <a href="{{route('admin.reports')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-document-search"></i></span>
                        <span class="pcoded-mtext">Reports</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>
                <li  class="{{ (Route::is('admin.home_cities') ? 'active' : '') }}">
                        <a href="{{route('admin.home_cities')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-earth"></i></span>
                        <span class="pcoded-mtext">Manage Home Cities</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>
                <li  class="{{ (Route::is('admin.slider') ? 'active' : '') }}">
                        <a href="{{route('admin.slider')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-ui-image"></i></span>
                        <span class="pcoded-mtext">Manage Home Page Sliders</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>
                <li  class="{{ (Route::is('admin.bottom_slider') ? 'active' : '') }}">
                        <a href="{{route('admin.bottom_slider')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-ui-image"></i></span>
                        <span class="pcoded-mtext">Home Page Bottom Sliders</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>               
                <li class="pcoded-hasmenu {{ ((Route::is('admin.posts') || Route::is('admin.categories') || Route::is('admin.tags')) ? 'active' : '' ) }}">
                        <a href="javascript:void(0)" data-i18n="nav.navigate.main">
                        <span class="pcoded-micon"><i class="icofont icofont-ui-v-card"></i></span>
                        <span class="pcoded-mtext">Posts</span>
                        <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                                <li class=" ">
                                <a href="{{route('admin.posts')}}" data-i18n="nav.navigate.navbar">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Manage Posts</span>
                                <span class="pcoded-mcaret"></span>
                                </a>
                                </li>
                                <li class=" ">
                                <a href="{{route('admin.categories')}}" data-i18n="nav.navigate.navbar">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Manage Categories</span>
                                <span class="pcoded-mcaret"></span>
                                </a>
                                </li>
                                <li class=" "> 
                                <a href="{{route('admin.tags')}}" data-i18n="nav.navigate.navbar-inverse">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Manage Tags</span>
                                <span class="pcoded-mcaret"></span>
                                </a>
                                </li>                    
                        </ul>
                </li>
                <li  class="{{ (Route::is('admin.testimonials') ? 'active' : '') }}">
                        <a href="{{route('admin.testimonials')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-ui-v-card"></i></span>
                        <span class="pcoded-mtext">Testimonials</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>
                <li  class="{{ (Route::is('admin.our_community_banners') ? 'active' : '') }}">
                        <a href="{{route('admin.our_community_banners')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-ui-image"></i></span>
                        <span class="pcoded-mtext">Manage Our Communities</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>              
                <li  class="{{ (Route::is('admin.host_banners') ? 'active' : '') }}">
                        <a href="{{route('admin.host_banners')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-ui-image"></i></span>
                        <span class="pcoded-mtext">Manage Host Banners</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>
                <li class="pcoded-hasmenu {{ ((Route::is('admin.help') || Route::is('admin.help_category') || Route::is('admin.help_subcategory')) ? 'active' : '' ) }}">
                        <a href="javascript:void(0)" data-i18n="nav.navigate.main">
                        <span class="pcoded-micon"><i class="icofont icofont-support-faq"></i></span>
                        <span class="pcoded-mtext">Manage Help</span>
                        <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                                <li class=" ">
                                <a href="{{route('admin.help')}}" data-i18n="nav.navigate.navbar">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Help</span>
                                <span class="pcoded-mcaret"></span>
                                </a>
                                </li>
                                <li class=" ">
                                <a href="{{route('admin.help_category')}}" data-i18n="nav.navigate.navbar">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Category</span>
                                <span class="pcoded-mcaret"></span>
                                </a>
                                </li>
                                <li class=" "> 
                                <a href="{{route('admin.help_subcategory')}}" data-i18n="nav.navigate.navbar-inverse">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Subcategory</span>
                                <span class="pcoded-mcaret"></span>
                                </a>
                                </li>                    
                        </ul>
                </li>
                <li class="pcoded-hasmenu {{ ((Route::is('admin.amenities') || Route::is('admin.amenities_type') || Route::is('admin.help_subcategory')) ? 'active' : '' ) }}">
                        <a href="javascript:void(0)" data-i18n="nav.navigate.main">
                        <span class="pcoded-micon"><i class="icofont icofont-bullseye"></i></span>
                        <span class="pcoded-mtext">Manage Amenities</span>
                        <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                                <li class=" ">
                                <a href="{{route('admin.amenities')}}" data-i18n="nav.navigate.navbar">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Amenities</span>
                                <span class="pcoded-mcaret"></span>
                                </a>
                                </li>
                                <li class=" ">
                                <a href="{{route('admin.amenities_type')}}" data-i18n="nav.navigate.navbar">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Amenities Type</span>
                                <span class="pcoded-mcaret"></span>
                                </a>
                                </li>                                                 
                        </ul>
                </li>
                <li class="pcoded-hasmenu {{ ((Route::is('admin.subscriptions_free') || Route::is('admin.subscriptions_plan')) ? 'active' : '' ) }}">
                        <a href="javascript:void(0)" data-i18n="nav.navigate.main">
                        <span class="pcoded-micon"><i class="icofont icofont-bullseye"></i></span>
                        <span class="pcoded-mtext">Manage Subscriptions</span>
                        <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                                <li class=" ">
                                <a href="{{route('admin.subscriptions_plan')}}" data-i18n="nav.navigate.navbar">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Subscriptions Plan</span>
                                <span class="pcoded-mcaret"></span>
                                </a>
                                </li>
                                <li class=" ">
                                <a href="{{route('admin.subscriptions_free')}}" data-i18n="nav.navigate.navbar">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Subscriptions Type</span>
                                <span class="pcoded-mcaret"></span>
                                </a>
                                </li>                                                 
                        </ul>
                </li>
                <li  class="{{ (Route::is('admin.property_manager') ? 'active' : '') }}">
                        <a href="{{route('admin.property_manager')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-building"></i></span>
                        <span class="pcoded-mtext">Manage Property Managers</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>
                <li  class="{{ (Route::is('admin.property_type') ? 'active' : '') }}">
                        <a href="{{route('admin.property_type')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-building"></i></span>
                        <span class="pcoded-mtext">Manage Property Type</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>
                <li  class="{{ (Route::is('admin.room_type') ? 'active' : '') }}">
                        <a href="{{route('admin.room_type')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-home"></i></span>
                        <span class="pcoded-mtext">Manage Room Type</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>
                <li  class="{{ (Route::is('admin.bed_type') ? 'active' : '') }}">
                        <a href="{{route('admin.bed_type')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-bed"></i></span>
                        <span class="pcoded-mtext">Manage Bed Type</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>
                <li class="pcoded-hasmenu {{ ((Route::is('admin.pages') || Route::is('admin.templates')) ? 'active' : '' ) }}">
                        <a href="javascript:void(0)" data-i18n="nav.navigate.main">
                        <span class="pcoded-micon"><i class="icofont icofont-bullseye"></i></span>
                        <span class="pcoded-mtext">Manage Pages</span>
                        <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                                <li class=" ">
                                <a href="{{route('admin.pages')}}" data-i18n="nav.navigate.navbar">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Manage Static Pages</span>
                                <span class="pcoded-mcaret"></span>
                                </a>
                                </li>
                                <li class=" ">
                                <a href="{{route('admin.templates')}}" data-i18n="nav.navigate.navbar">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Templates</span>
                                <span class="pcoded-mcaret"></span>
                                </a>
                                </li>                                                 
                        </ul>
                </li>
                <li  class="{{ (Route::is('admin.currency') ? 'active' : '') }}">
                        <a href="{{route('admin.currency')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-cur-dollar"></i></span>
                        <span class="pcoded-mtext">Manage Currency</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>                        
                <li  class="{{ (Route::is('admin.language') ? 'active' : '') }}">
                        <a href="{{route('admin.language')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-world"></i></span>
                        <span class="pcoded-mtext">Manage Language</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>                        
                <li  class="{{ (Route::is('admin.country') ? 'active' : '') }}">
                        <a href="{{route('admin.country')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-globe-alt"></i></span>
                        <span class="pcoded-mtext">Manage Country</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>
                <li  class="{{ (Route::is('admin.referral_settings') ? 'active' : '') }}">
                        <a href="{{route('admin.referral_settings')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-ui-user-group"></i></span>
                        <span class="pcoded-mtext">Manage Referral Settings</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>                        
                <li  class="{{ (Route::is('admin.fees') ? 'active' : '') }}">
                        <a href="{{route('admin.fees')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-cur-dollar"></i></span>
                        <span class="pcoded-mtext">Discount Management</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>                        
                <li  class="{{ (Route::is('admin.metas') ? 'active' : '') }}">
                        <a href="{{route('admin.metas')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-chart-bar-graph"></i></span>
                        <span class="pcoded-mtext">Metas Management</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>                        
                <li  class="{{ (Route::is('admin.api_credentials') ? 'active' : '') }}">
                        <a href="{{route('admin.api_credentials')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-chart-bar-graph"></i></span>
                        <span class="pcoded-mtext">API Credentials</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>
                <li  class="{{ (Route::is('admin.payment_gateway') ? 'active' : '') }}">
                        <a href="{{route('admin.payment_gateway')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-social-pandora"></i></span>
                        <span class="pcoded-mtext">Payment Gateway</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>  
                <li  class="{{ (Route::is('admin.join_us') ? 'active' : '') }}">
                        <a href="{{route('admin.join_us')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-ui-social-link"></i></span>
                        <span class="pcoded-mtext">Join Us Links</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>
                <li  class="{{ (Route::is('admin.theme_settings') ? 'active' : '') }}">
                        <a href="{{route('admin.theme_settings')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-eye"></i></span>
                        <span class="pcoded-mtext">Theme Setting</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>
                <li  class="{{ (Route::is('admin.site_settings') ? 'active' : '') }}">
                        <a href="{{route('admin.site_settings')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-settings-alt"></i></span>
                        <span class="pcoded-mtext">Site Setting</span>
                        <span class="pcoded-mcaret"></span>                        
                        </a>
                </li>              
           </ul>
           
        </div>
     </nav>
     