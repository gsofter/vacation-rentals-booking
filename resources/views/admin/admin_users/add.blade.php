@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                  <h4>Admin User Management</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.admin.users')}}">Admin User</a></li>
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
                                <h5>Add Admin User Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{url('admin/add_admin_user')}}" accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                                {{ csrf_field() }}
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">First Name<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="first_name" class="form-control" placeholder="Write First Name..." required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Last Name<span class="text-danger" >*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="last_name" class="form-control" placeholder="Write Last Name..." required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">User Name<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="username" class="form-control" placeholder="Write User Name..." required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Email<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="email" name="email" class="form-control" placeholder="Write Email..." required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Bio<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="bio" class="form-control" placeholder="Write Bio..." required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Password<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="password" name="password" class="form-control" placeholder="Write password..." required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Role Type<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                        <select name="role" class="form-control form-control-default" required>
                                            <option value="-1">Select Role Type</option>
                                            @if(count($data) != 0)
                                                @foreach($data as $row)
                                                 <option value="{{$row->id}}">{{$row->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Support Contact<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                        <select name="support_contact" class="form-control form-control-default" required>
                                            <option value="-1">Select Support Contact</option>
                                            <option value="1">Yes</option>                                            
                                            <option value="0">No</option>                                            
                                        </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Status<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                        <select name="status" class="form-control form-control-default" required>
                                            <option value="-1">Select Status</option>
                                            <option value="1">Active</option>                                            
                                            <option value="0">Inactive</option> 
                                        </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-info btn-round">Submit</button>
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

@stop