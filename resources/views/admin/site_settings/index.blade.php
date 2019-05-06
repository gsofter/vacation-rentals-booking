@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                    <h4>Site Settings Manage</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item">Site Settings</li>                     
                  </ul>
               </div>
            </div>
            <div class="page-body">
               <div class="row">
                 
                <div class="col-sm-12">

                    <div class="card">
                    <div class="card-header table-card-header">  
                        <div class="row">
                            <div class="col-sm-9 text-left">
                                <h5>Site Settings Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{url('admin/site_settings')}}" enctype="multipart/form-data" accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                                {{ csrf_field() }}
                            @foreach($siteSettings as $site)
                                @if($site->flag=="1")
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">{{$site->name}}<span class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" name="{{$site->name}}" value="{{$site->value}}" class="form-control"  required>
                                        </div>
                                    </div> 
                                @elseif($site->flag=="2")
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">{{$site->name}}<span class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                            <textarea type="text" style="height:200px;" name="{{$site->name}}" class="form-control"  required>{{$site->value}}</textarea>
                                        </div>
                                    </div>
                                @elseif($site->flag=="3") 
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">{{$site->name}}<span class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="file" name="{{$site->name}}" id="input-file-now1" data-default-file="{{asset("images/logos/$site->value")}}" class="dropify"  />
                                            <input type="hidden" value="{{$site->value}}" name="orginal_{{$site->name}}">
                                        </div>
                                    </div>  
                                @elseif($site->flag=="4")
                                    @if($site->name=="default_home")
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label text-right">Default Home Page<span class="text-danger">*</span></label>                                        
                                            <div class="col-sm-6">
                                                <select class="form-control" name="default_home">
                                                    <option value="home_one" <?php echo $site->value=="home_one"?"selected":""; ?>>Home Page 1</option>
                                                    <option value="home_two" <?php echo $site->value=="home_two"?"selected":""; ?>>Home Page 2</option>
                                                </select>
                                            </div>
                                        </div>
                                    @elseif($site->name=="paypal_currency")
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label text-right">Currency Provider<span class="text-danger">*</span></label>                                        
                                            <div class="col-sm-6">
                                                <select class="form-control" name="paypal_currency">
                                                    @foreach($paypalCurrencies as $pay)
                                                        <option value="{{$pay->code}}" <?php echo $site->value==$pay->code?"selected":""; ?>>{{$pay->code}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>                                    
                                    @elseif($site->name=="upload_driver")
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label text-right">File Upload Driver<span class="text-danger">*</span></label>                                        
                                            <div class="col-sm-6">
                                                <select class="form-control" name="upload_driver">
                                                    <option value="php" <?php echo $site->value=="php"?"selected":""; ?>>Local</option>
                                                    <option value="cloudinary" <?php echo $site->value=="cloudinary"?"selected":""; ?>>Cloudinary</option>
                                                </select>
                                            </div>
                                        </div>
                                    @elseif($site->name=="currency_provider")
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label text-right">Currency Rate Provider<span class="text-danger">*</span></label>                                        
                                            <div class="col-sm-6">
                                                <select class="form-control" name="currency_provider">
                                                    <option value="google_finance" <?php echo $site->value=="google_finance"?"selected":""; ?>>Google Finance</option>
                                                    <option value="yahoo_finance" <?php echo $site->value=="yahoo_finance"?"selected":""; ?>>Yahoo Finance</option>
                                                </select>
                                            </div>
                                        </div>
                                    @elseif($site->name=="site_date_format")
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label text-right">Site Date Format<span class="text-danger">*</span></label>                                        
                                            <div class="col-sm-6">
                                                <select class="form-control" name="site_date_format">
                                                    @foreach($dateFormats as $date)
                                                        <option value="{{$date->id}}" <?php echo $site->value==$date->id?"selected":""; ?>>{{$date->display_format}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                   
                                @endif
                            @endforeach            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Default Currency<span class="text-danger">*</span></label>                                        
                                <div class="col-sm-6">
                                    <select class="form-control" name="default_currency">
                                        @foreach($currencies as $cur)
                                            <option value="{{$cur->id}}" <?php echo $default_currency==$cur->id?"selected":""; ?>>{{$cur->code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Default Language<span class="text-danger">*</span></label>                                        
                                <div class="col-sm-6">
                                    <select class="form-control" name="default_language">
                                        @foreach($languages as $lng)
                                            <option value="{{$lng->id}}" <?php echo $default_language==$lng->id?"selected":""; ?>>{{$lng->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" id="createuserbtn" class="btn btn-info btn-round">Submit</button>                                    
                                </div>
                            </div>
                        </form>


                    </div>
                    </div>
               </div>
            </div>

         </div>
         <div id="styleSelector"></div>
      </div>
   </div>
</div>  
 <script>
       $('.dropify').dropify();

 </script>
@stop