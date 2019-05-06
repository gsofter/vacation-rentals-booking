@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                    <h4>Reservation Detail</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.reservations')}}">Reservations</a></li> 
                     <li class="breadcrumb-item">Details</li>                     
                  </ul>
               </div>
            </div>
            <div class="page-body">
               <div class="row">
                 
                <div class="col-sm-12">

                    <div class="card">
                    <div class="card-header table-card-header">  
                        <div class="row">
                            <div class="col-sm-12 text-left">
                                <h5>Reservation Detail</h5>
                            </div>                         
                                                    
                        </div>                          
                        
                    </div>
                    <div class="card-block">  
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Room Name:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$reservation->getRoomNameByRoomID()}} - <a href="edit_room/{{$reservation->room_id}}">{{$reservation->room_id}}</a></span>
                                </div>
                            </div>                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Host Name:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$reservation->getFullUserNameByHostID()}} - <a href="edit_user/{{$reservation->host_id}}">{{$reservation->host_id}}</a></span>                                     
                                </div>
                            </div>   
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Guest Name:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$reservation->getFullUserNameByUserID()}} - <a href="edit_user/{{$reservation->user_id}}">{{$reservation->user_id}}</a></span>                                     
                                </div>
                            </div>   
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Checkin:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$reservation->checkin}}</span>                                    
                                </div>
                            </div>   
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Checkout:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$reservation->checkout}}</span>                                    
                                </div>
                            </div>   
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Number of guests:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$reservation->number_of_guests}}</span>                                    
                                </div>
                            </div>   
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Cancellation Policy:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$reservation->cancellation}}</span>                                    
                                </div>
                            </div>   


                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Cancellation:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$reservation->cancellation}}</span>                                    
                                </div>
                            </div>   
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Total nights:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$reservation->nights}}</span>                                    
                                </div>
                            </div>   
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">p{{$reservation->per_night}} x {{$reservation->nights}}:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">p{{$reservation->subtotal}}</span>                                    
                                </div>
                            </div>   
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Cleaning fee:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">p{{$reservation->cleaning}}</span>                                    
                                </div>
                            </div>   
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Additional guest fee:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">p{{$reservation->additional_guest}}</span>                                    
                                </div>
                            </div>   
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Subtotal amount:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">p{{$reservation->total}}</span>                                    
                                </div>
                            </div>   
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Currency:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$reservation->currency_code}}</span>                                    
                                </div>
                            </div>   
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Status:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$reservation->status}}</span>                                    
                                </div>
                            </div>   
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Country:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$reservation->country}}</span>                                    
                                </div>
                            </div>   
                            
                            
                            
                            
                            <div class="form-group row">
                                <div class="col-sm-12 text-center">                                   
                                    <a href="{{route('admin.reservations')}}" class="btn btn-default btn-round">Back</a>
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