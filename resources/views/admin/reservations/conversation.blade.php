@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                    <h4>Conversation Details</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.reservations')}}">Conversation</a></li>                     
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
                                <h5>Conversation Details</h5>
                            </div>                         
                                                    
                        </div>                          
                        
                    </div>
                    <div class="card-block">  
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Room ID:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$reservation->room_id}}</span>
                                </div>
                            </div>                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Room Name:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$reservation->getRoomNameByRoomID()}}</span>
                                </div>
                            </div>                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Host Name:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$reservation->getFullUserNameByHostID()}}</span>                                     
                                </div>
                            </div>   
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">Guest Name:</label>
                                <div class="col-sm-6">
                                    <span class="form-control" style="border:unset;">{{$reservation->getFullUserNameByUserID()}}</span>                                     
                                </div>
                            </div>   

                            <div class="col-sm-12 text-left">
                                <h5>Chat Details</h5>
                            </div>

                            
                            <div class="form-group">
                                @if ($message->count()>0)
                                    @foreach ($message as $item)
                                    <div class="row" style="margin-bottom:5px;">
                                        <div class="col-sm-2 col-form-label text-center">
                                            @php
                                                $image = $item->getUserImageByID();
                                            @endphp
                                            @if ($image->photo_source=="Local")                                               
                                                @if ($image->src)
                                                    <img class="img-circle" src="{{asset("images/users/$item->user_from/$image->src")}}" style="height:50px">
                                                @else
                                                    <img class="img-circle" src="{{asset("images/users/$item->user_from/avatar.jpg")}}" style="height:50px">                                                
                                                @endif                                                
                                            @else
                                                <img class="img-circle" src="{{$image->src}}" style="height:50px">
                                            @endif
                                            <br>
                                            {{$item->getFullUserNameByFromUserID()}}
                                        </div>
                                        <div class="col-sm-8">
                                            <span class="form-control usermessage" style="border:unset;">{{$item->message}}</span>
                                            <br>
                                            <span class="text-left">{{$item->created_at}}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                    
                                @endif
                                
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