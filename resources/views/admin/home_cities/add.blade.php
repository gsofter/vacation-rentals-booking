@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                  <h4>Add Home Cities</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.home_cities')}}">Home Cities</a></li>
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
                                <h5>Add Home Cities Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{url('admin/add_home_city')}}" enctype="multipart/form-data"  accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                                {{ csrf_field() }}
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">City Name<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="name" class="form-control" placeholder="City Name" required>
                                </div>
                            </div>
                            
                                
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Country<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="country" class="form-control form-control-default" required>
                                    @foreach($countries as $con)
                                        <option value="{{$con->long_name}}">{{$con->long_name}}</option> 
                                    @endforeach
                                    </select>
                                </div>
                            </div>
        
    
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Image<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="file" name="image" id="input-file-now1" class="dropify required" required />
                                </div>
                            </div>                            
                  

                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" id="createuserbtn" class="btn btn-info btn-round">Submit</button>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="{{route('admin.home_cities')}}" class="btn btn-default btn-round">Cancel</a>
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