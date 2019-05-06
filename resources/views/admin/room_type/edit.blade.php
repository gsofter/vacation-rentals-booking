@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                    <h4>Room Type Manage</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.room_type')}}">Room Type</a></li>
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
                                <h5>Edit Room Type Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{url('admin/edit_room_type/'.$roomtype->id)}}"  accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$roomtype->id}}" name="id">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Name<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="name" class="form-control" value="{{$roomtype->name}}" placeholder="name" required>
                                </div>
                            </div>                                          
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Description<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <textarea type="text" name="description" class="form-control required" placeholder="Write Description..." required>
                                        {{$roomtype->description}}
                                    </textarea>
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Is Shared Room?<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="is_shared" class="form-control form-control-default required" required>   
                                        <option value="Yes" <?php echo $roomtype->is_shared=="Yes"?"selected":""; ?>>Yes</option>                                            
                                        <option value="No" <?php echo $roomtype->is_shared=="No"?"selected":""; ?>>No</option> 
                                    </select>
                                </div>
                            </div>                                       
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Status<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="status" class="form-control form-control-default required" required>   
                                        <option value="Active" <?php echo $roomtype->status=="Active"?"selected":""; ?>>Active</option>                                            
                                        <option value="Inactive" <?php echo $roomtype->status=="Inactive"?"selected":""; ?>>Inactive</option> 
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" id="createuserbtn" class="btn btn-info btn-round">Submit</button>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="{{route('admin.room_type')}}" class="btn btn-default btn-round">Cancel</a>
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