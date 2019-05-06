@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                  <h4>Admin User Role Management</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>                    
                     <li class="breadcrumb-item"><a href="{{route('admin.admin.roles')}}">Admin User Roles</a></li>
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
                                <h5>Add Admin User Role Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{url('admin/edit_admin_role/' . $role->id)}}" accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{$role->id}}" name="id">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Name<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="name" class="form-control" value="{{$role->name}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Display Name<span class="text-danger" >*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="display_name" class="form-control" value="{{$role->display_name}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Description<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <textarea type="text" name="description" class="form-control"  required>{{$role->description}}</textarea>
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Permission</label>
                                <div class="col-sm-9 row">
                                    @foreach($permissions as $item)
                                    @php
                                        $flag = 0;
                                        foreach($rolepermissions as $r){
                                            if($item->id == $r->permission_id) $flag = 1;
                                        }
                                    @endphp
                                        
                                      
                                        <div class="border-checkbox-group border-checkbox-group-primary col-sm-4">
                                                
                                                
                                            <input class="border-checkbox" type="checkbox" <?php echo $flag==1?"checked":""; ?> name="permission[]" value="{{ $item->id }}">
                                            
                                            <label class="border-checkbox-label" for="checkbox1">{{$item->display_name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>



                            
                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-info btn-round">Submit</button>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="{{route('admin.admin.roles')}}" class="btn btn-default btn-round">Cancel</a>
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