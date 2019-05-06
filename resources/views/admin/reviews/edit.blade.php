@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                  <h4>User Management</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.reviews')}}">Reviews</a></li>
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
                                <h5>Edit Review Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{url('admin/edit_review/' . $review->id)}}" accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{$review->id}}" name="id">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Reservation Id</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="{{$review->reservation_id}}" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Room Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="{{$review->getRoomName()}}" disabled>
                                </div>
                            </div>                            
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">User From</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="{{$review->getUserFromName()}}" disabled>
                                </div>
                            </div>                            
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">User To</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="{{$review->getUserToName()}}" disabled>
                                </div>
                            </div>                            
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Review By</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" value="{{$review->review_by}}" disabled>
                                </div>
                            </div>                            
                            

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Comments<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <textarea type="text" name="comments" class="form-control" >{{$review->comments}}</textarea>
                                </div>
                            </div>    

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Status<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                        <select name="status" class="form-control form-control-default" required>
                                            <option value="Active" <?php echo $review->status=="Active"?"selected":"";  ?>>Active</option>                                            
                                            <option value="Inactive" <?php echo $review->status=="Inactive"?"selected":"";  ?>>Inactive</option> 
                                        </select>
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