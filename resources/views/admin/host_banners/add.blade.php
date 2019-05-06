@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                    <h4>Host Banners Manage</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.host_banners')}}">Host Banners</a></li>
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
                                <h5>Add Host Banner Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{url('admin/add_host_banners')}}" enctype="multipart/form-data"  accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                                {{ csrf_field() }}

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Image<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="file" name="image" id="input-file-now1" class="dropify required" required />
                                </div>
                            </div>      
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Title<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="title" class="form-control"  placeholder="Title" required>
                                </div>
                            </div>
                                          
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Description<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <textarea  name="description" class="form-control"  placeholder="Description" required></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Link Title<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="link_title" class="form-control" placeholder="Link Title" required>
                                </div>
                            </div>
                                          
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Link<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="link" class="form-control" placeholder="Link..." required>
                                </div>
                            </div>
                                         

                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" id="createuserbtn" class="btn btn-info btn-round">Submit</button>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="{{route('admin.host_banners')}}" class="btn btn-default btn-round">Cancel</a>
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