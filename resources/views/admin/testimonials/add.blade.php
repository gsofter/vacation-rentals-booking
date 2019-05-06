@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                    <h4>Testimonials Manage</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.posts')}}">Testimonials</a></li>
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
                                <h5>Add Testimonial Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{url('admin/add_testimonial')}}" enctype="multipart/form-data"  accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                            {{ csrf_field() }}
                       
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Title<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="title" class="form-control"  placeholder="Title" required>
                                </div>
                            </div>
                                          
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Excerpt<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="excerpt" class="form-control"  placeholder="Excerpt" required>
                                </div>
                            </div>
                             
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Content<span class="text-danger">*</span></label>
                                <div class="col-sm-6">                                       
                                    <textarea name="content" class="summernote"></textarea>
                                </div>             
                            </div>       

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Author<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="author_id"  class="categories-select form-control required" required>
                                        <option value="">Select</option>                                            
                                        @foreach($authores as $row)
                                            <option value="{{$row->id}}">{{$row->first_name}} {{$row->last_name}}</option>
                                        @endforeach                                           
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Status<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="status" class="form-control form-control-default required categories-select"  required>
                                        <option value="draft">Draft</option>
                                        <option value="publish">Publish</option>                                            
                                        <option value="pending">Pending</option> 
                                    </select>
                                </div>
                            </div>       
                           
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Featured</label>
                                <div class="col-sm-6 checkbox-fade fade-in-default">
                                    <label>
                                        <input type="checkbox" name="featured" value="1" class="form-control">
                                        <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-default"></i>
                                        </span> 
                                    </label>                                   
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Publish Date</label>
                                <div class="col-sm-6">
                                    <input id="dropper-format" name="publish_date" class="form-control required " type="text" value="{{date('Y-m-d')}}" required />
                                </div>
                            </div>
                        </div>
                                                   
                                
                        <div class="col-sm-12 text-center" style="margin-bottom:10px;">
                            <button type="submit" id="createuserbtn" class="btn btn-info btn-round">Submit</button>
                            &nbsp;&nbsp;&nbsp;
                            <a href="{{route('admin.testimonials')}}" class="btn btn-default btn-round">Cancel</a>
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
        $('.categories-select').select2();
        $('.summernote').summernote({
            height: 300
        });

        $("#dropper-format").dateDropper( {
            dropWidth: 200,
            format: "Y-m-d",
            dropPrimaryColor: "#1abc9c", 
            dropBorder: "1px solid #1abc9c"
        });
       
    </script>
 
@stop