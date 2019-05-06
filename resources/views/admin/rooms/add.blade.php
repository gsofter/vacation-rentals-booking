@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                  <h4>Room Management</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.rooms')}}">Rooms</a></li>
                     <li class="breadcrumb-item">Add</li>
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
                                <h5>Add Room Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{url('admin/add_room')}}" accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                            {{ csrf_field() }}
                            
                            <style>
                                .md-tabs .nav-item{
                                    width: calc(100%/16) !important;
                                    background-color: #bdc3c7 !important;
                                }
                                .nav-tabs .slide {
                                    background: #1abc9c;
                                    width: calc(100%/16);                                   
                                }
                                .md-tabs .nav-item:nth-child(9), .md-tabs .nav-item:nth-child(10), .md-tabs .nav-item:nth-child(11),.nav-tabs li .slide:nth-child(9),.nav-tabs li .slide:nth-child(10),.nav-tabs li .slide:nth-child(11){
                                    width:150px !important;
                                }
                                .md-tabs .nav-item:nth-child(3),.nav-tabs li .slide:nth-child(3){
                                    width:120px !important;
                                }
                               
                                .nav-tabs li{
                                    margin-right: 3px !important;
                                }
                                .md-tabs .nav-item a{
                                    padding: 10px !important;
                                }
                            </style>
                            <div class="form-group row">
                                    <div class="col-sm-12" style="padding-left: 65px;">
                                        <ul class="nav nav-tabs md-tabs " role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#Calendar" role="tab" >Calendar</a>
                                                <div class="slide"></div>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#Basic" role="tab">Basic</a>
                                                <div class="slide"></div>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#Description" role="tab">Description</a>
                                                <div class="slide"></div>
                                            </li>                                        
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#Location" role="tab">Location</a>
                                                <div class="slide"></div>
                                            </li>                                        
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#Amenities" role="tab">Amenities</a>
                                                <div class="slide"></div>
                                            </li>                                        
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#Photos" role="tab">Photos</a>
                                                <div class="slide"></div>
                                            </li>                                        
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#Video" role="tab">Video</a>
                                                <div class="slide"></div>
                                            </li>                                        
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#Pricing" role="tab">Pricing</a>
                                                <div class="slide"></div>
                                            </li>                                        
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#price_rules" role="tab">Price Rules</a>
                                                <div class="slide"></div>
                                            </li>                                        
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#availability_rules" role="tab">Availability Rules</a>
                                                <div class="slide"></div>
                                            </li>                                        
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#booking_type" role="tab">Booking Type</a>
                                                <div class="slide"></div>
                                            </li>                                        
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#Terms" role="tab">Terms</a>
                                                <div class="slide"></div>
                                            </li>                                        
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#Meta" role="tab">Meta</a>
                                                <div class="slide"></div>
                                            </li>                                        
                                        </ul>
                                        <div class="tab-content card-block">

                                            <div class="tab-pane active" id="Calendar" role="tabpanel" >
                                                <p>This is first tab</p>
                                            </div>


                                            <div class="tab-pane" id="Basic" role="tabpanel">
                                                <div class="form-group row col-sm-12">
                                                    <label class="col-form-label text-right">Slug</label>
                                                    <div class=" input-group">                                                        
                                                        <span class="input-group-addon" id="basic-addon1">/</span>
                                                        <input type="text" class="form-control"  name="permalink[slug]">
                                                    </div>
                                                </div>
                                                   
                                                    
                                            </div>
                                            <div class="tab-pane" id="Description" role="tabpanel">
                                                
                                                  
                                            </div>                                           
                                        </div>
                                    </div>
                                </div>
    




                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="button" id="createuserbtn" class="btn btn-info btn-round">Submit</button>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="{{route('admin.admin.users')}}" class="btn btn-default btn-round">Cancel</a>
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
        $("#phonenumber").intlTelInput({
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
        });

        $(document).on('click', '#createuserbtn', function(){
            if($('#password').val() == $('#confirm_password').val()){
                $('form').submit();
            }else{
                alert("Must be matched password and confirm password!");
            }
        });
    </script>
 
@stop