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
                                <h5>Edit Room Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                     {{--  {{ $room }}
                     {{ $membership_types }}  --}}
                      <form method="POST">
                        @csrf
                        @if($room->hasActiveSubscription())
                        <div class="form-group">
                          <label for="plan_type">Membership</label>
                          <select class="form-control" name="plan_type">
                            
                            @foreach($membership_types as $type)
                            <option value="{{ $type->id }}" @if($type->id == $room->plan_type) selected @endif>{{ $type->Name }}</option>
                            @endforeach
                          </select>
                        </div>
                        @else
                        <div class="form-group">
                            <label for="plan_type">Membership</label>
                            <div class="alert alert-danger form-control" role="alert">
                               This room does not subscribed yet.
                              </div>
                          </div>
                      
                        @endif
                        @if($room->hasActiveSubscription())
                        <div class="form-group">
                            <label for="plan_type">Subscription Start Date</label>
                            <input class="form-control"  readonly value="{{ $room->subscription_start_date }}"/>
                          </div>
                        <div class="form-group">
                            <label for="plan_type">Subscription End Date</label>
                            <input class="form-control"  readonly value="{{ $room->subscription_end_date }}"/>
                        </div>
                        <div class="form-group">
                            <label for="plan_type">Subscription Days</label>
                            <input class="form-control"  readonly value="{{ $room->subscription_days }}"/>
                        </div>
                        @endif
                         <div class="form-group">
                          <label for="status">Status</label>
                          
                          @if($room->steps_count > 0 )
                          <div class="alert alert-danger form-control" role="alert">
                              This room did not complete all fields yet.
                             </div>
                          
                          @else
                          <select class="form-control" name="status">
                              <option @if($room->status ='Listed') selected @endif value="Listed">Listed</option>
                              <option @if($room->status ='Unlisted') selected @endif value="Unlisted">Unlisted</option>
                              <option @if($room->status ='Draft') selected @endif value="Draft">Draft</option>
                            </select>
                          @endif
                          
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </form>

                    </div>
                    </div>
                    @if($room->hasActiveSubscription())
                    <div class="card">
                        <div class="card-header table-card-header">  
                            <div class="row">
                                <div class="col-sm-9 text-left">
                                    <h5>Add Extends Date</h5>
                                </div>                          
                                <div class="col-sm-3 text-right">
                                    <span class="text-danger">(*)Fields are Mandatory</span>
                                </div>                          
                            </div>                          
                        </div>
                        <div class="card-block">
                          
                         
                          <form method="POST">
                            @csrf
                            <input name="action" value="updatemembership" type="hidden"/>
                              <div class="form-group">
                              <label>Choose Date</label>
                              <input id="dropper-default" name="extend_date" data-dd-default-date="{{ $room->subscription_end_date}}" value="{{ $room->subscription_end_date}}" data-dd-format="Y-m-d" class="form-control required" type="text" placeholder="Select your date" required />
                              </div>
                            <button type="submit" class="btn btn-primary">Apply</button>
                          </form>
    
                        </div>
                    </div>
                    @endif
               </div>
            </div>
            </div>

         </div>
         <div id="styleSelector"></div>
      </div>
   </div>
</div>
  
<script>
  

 
</script>
 
@stop