@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                    <h4>Extend Subscription</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.subscriptions_plan')}}">Subscriptions</a></li>
                     <li class="breadcrumb-item">Edit</li>
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
                                <h5>Subscription Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">User Name:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$subscribelist->getUserNameByHostID()}}</span>                                     
                                </div>
                            </div>   
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Room Name:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$subscribelist->getRoomNameByRoomID()}}</span>
                                </div>
                            </div>   
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Subscription End Date:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$subscribelist->subscription_end_date}}</span>                                    
                                </div>
                            </div>   
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Subscription Extend Date:</label>
                                <div class="col-sm-6">
                                    <input id="dropper-default" name="extend_date" class="form-control" type="text" />
                                
                                </div>
                            </div>   
                            
                            
                            
                            <div class="form-group row">
                                <div class="col-sm-12 text-center">                                   
                                    <a href="{{route('admin.subscriptions_free')}}" class="btn btn-default btn-round">Cancel</a>
                                </div>
                            </div>
                       

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

    $("#dropper-default").dateDropper( {
        dropWidth: 200,
        format: "Y-m-d",
        dropPrimaryColor: "#1abc9c", 
        dropBorder: "1px solid #1abc9c"
    });
 </script>
@stop