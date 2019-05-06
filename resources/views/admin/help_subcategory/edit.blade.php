@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                    <h4>Help Subcategory Manage</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.help_subcategory')}}">Help Subcategory</a></li>
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
                                <h5>Edit  Help Subcategory Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{url('admin/edit_help_subcategory/'.$helpsubcategory->id)}}"  accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$helpsubcategory->id}}" name="id">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Name<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="name" class="form-control" value="{{$helpsubcategory->name}}" placeholder="name" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Category<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="category_id" class="form-control form-control-default required" required> 
                                        @foreach($categories as $cat)            
                                            <option value="{{$cat->id}}" <?php echo $helpsubcategory->category_id==$cat->id?"selected":""; ?>>{{$cat->name}}</option> 
                                        @endforeach
                                    </select>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Description<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <textarea type="text" name="description" class="form-control required" placeholder="Write Description..." required>
                                        {{$helpsubcategory->description}}
                                    </textarea>
                                </div>
                            </div>                                         
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Status<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="status" class="form-control form-control-default required" required>   
                                        <option value="Active" <?php echo $helpsubcategory->status=="Active"?"selected":""; ?>>Active</option>                                            
                                        <option value="Inactive" <?php echo $helpsubcategory->status=="Inactive"?"selected":""; ?>>Inactive</option> 
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" id="createuserbtn" class="btn btn-info btn-round">Submit</button>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="{{route('admin.help_subcategory')}}" class="btn btn-default btn-round">Cancel</a>
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