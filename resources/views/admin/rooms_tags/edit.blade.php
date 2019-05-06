@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                  <h4>Edit Rooms Tags</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.rooms_tags')}}">Rooms Tags</a></li>
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
                                <h5>Edit Rooms Tag Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{url('admin/edit_room_tag/'.$roomTag->id)}}" enctype="multipart/form-data"  accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{$roomTag->id}}" name="id">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">City Name<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="name" value="{{$roomTag->name}}" class="form-control" placeholder="City Name" required>
                                </div>
                            </div>
                             
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Image<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="file" name="image" id="input-file-now1" data-default-file="{{asset("images/rooms/tags/$roomTag->image")}}" class="dropify"  />
                                    <input type="hidden" value="{{$roomTag->image}}" name="orginalimage">
                                </div>
                            </div>                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Description<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <textarea  name="description" class="form-control" placeholder="Description" required>{{$roomTag->description}}</textarea>
                                </div>
                            </div>    

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Status<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="status" class="form-control form-control-default" required>                                    
                                        <option value="">Select</option>                                     
                                        <option value="Active" <?php echo $roomTag->status=="Active"?"selected":""; ?>>Active</option>                                     
                                        <option value="Inactive" <?php echo $roomTag->status=="Inactive"?"selected":""; ?>>Inactive</option>                                     
                                    </select>
                                </div>
                            </div>        
                                

                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" id="createuserbtn" class="btn btn-info btn-round">Submit</button>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="{{route('admin.rooms_tags')}}" class="btn btn-default btn-round">Cancel</a>
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