@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                  <h4>Referrals Management</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.referrals')}}">Referrals</a></li>
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
                                <h5>Add Referrals Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        @include('admin/common/flash-message')

                        @yield('content')
                        <form method="POST" action="{{url('admin/add_referral')}}" accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                                {{ csrf_field() }}

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Referrer</label>
                                <div class="col-sm-6">
                                        <select name="user_id" id="user_id" class="form-control required" required>
                                            <option value="">Select</option>
                                            @if(count($referrals) != 0)
                                                @foreach($referrals as $row)
                                                    <option value="{{$row->id}}">{{$row->email}} - "ID" : {{$row->id}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Refferal</label>
                                <div class="col-sm-6">
                                        <select name="friend_id" id="friend_id" class="form-control required" required>
                                            <option value="">Select</option>                                                
                                            @if(count($referrals) != 0)
                                                @foreach($referrals as $row)
                                                <option value="{{$row->id}}">{{$row->email}} - "ID" : {{$row->id}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                </div>
                            </div>
                                    
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Credited Amount<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text"  name="credited_amount" id="credited_amount" class="form-control" placeholder="Credited Amount" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Status<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                        <select name="status" class="form-control required" required> 
                                            <option value="">Select</option>                                           
                                            <option value="Pending">Pending</option>                                            
                                            <option value="Completed">Completed</option> 
                                        </select>
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" id="createbtn" class="btn btn-info btn-round">Submit</button>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="{{route('admin.referrals')}}" class="btn btn-default btn-round">Cancel</a>
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
    
@stop