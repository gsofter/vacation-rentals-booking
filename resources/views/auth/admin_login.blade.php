<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Admin Login</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="description" content="Vacation.Rentals, booking">
      <meta name="keywords" content="Vacation.Rentals, booking">
      <meta name="author" content="Artemova">
      <link rel="icon" href="{{asset('admin_assets/assets/images/favicon.ico')}}" type="image/x-icon">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/icon/themify-icons/themify-icons.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/icon/icofont/css/icofont.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/css/style.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/assets/css/color/color-1.css')}}" id="color" />
      <link rel="stylesheet" type="text/css" href="{{asset('admin_assets/custom.css')}}" id="color" />
   </head>
   <body class="fix-menu">
      <section class="login p-fixed d-flex text-center bg-primary common-img-bg">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                  <div class="login-card card-block auth-body">
                     <form id="sign_in_adm" method="POST" action="{{ route('admin.login.submit') }}" class="md-float-material">
                        {{ csrf_field() }}
                        <div class="auth-box">
                           <div class="row m-b-20">
                              <div class="col-md-12">
                                 <span class="text-center text-primary">LOGIN TO</span>
                                 <br>
                                 <h3 class="text-center txt-primary text-danger">Vacation.Rentals</h3>
                              </div>
                           </div>
                           <hr />
                           <div class="input-group"> 
                              <input type="email" class="form-control border-radius-30px" name="email" placeholder="Email Address" value="{{ old('email') }}" required autofocus>
                              <span class="md-line"></span>
                              @if ($errors->has('email'))
                              <span class="text-danger"><strong>{{ $errors->first('email') }}</strong></span>
                              @endif
                           </div>
                           <div class="input-group">
                              <input type="password" class="form-control border-radius-30px" name="password" placeholder="Password" required>
                              <span class="md-line"></span>
                           </div>
                           <div>
                              <div class="text-center">
                                 <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20 border-radius-30px">SIGN IN</button>
                              </div>
                           </div>
                           <hr>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/jquery/dist/jquery.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/tether/dist/js/tether.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/modernizr/modernizr.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/modernizr/feature-detects/css-scrollbars.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/i18next/i18next.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/bower_components/jquery-i18next/jquery-i18next.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/assets/js/script.js')}}"></script>
      <script type="text/javascript" src="{{asset('admin_assets/assets/js/common-pages.js')}}"></script>
   </body>
</html>
