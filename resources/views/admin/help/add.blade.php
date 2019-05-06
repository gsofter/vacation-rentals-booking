@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                    <h4>Help Manage</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.help')}}">Help</a></li>
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
                                <h5>Add Help Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{url('admin/add_help')}}" enctype="multipart/form-data"  accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                                {{ csrf_field() }}

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Category<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="category_id" id="category" class="form-control form-control-default required select2" required>                                            
                                        <option value="">Select</option>
                                        @foreach($categories as $cat)            
                                            <option value="{{$cat->id}}">{{$cat->name}}</option> 
                                        @endforeach
                                    </select>
                                </div>
                            </div>                                          
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Subcategory</label>
                                <div class="col-sm-6">
                                    <select name="subcategory_id"  id="subcategory" class="form-control form-control-default required select2" required>                                            
                                        <option value="">Select Sub Category</option>
                                    </select>
                                </div>
                            </div>  
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Question<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="question" class="form-control"  placeholder="Question" required>
                                </div>
                            </div>   

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Answer<span class="text-danger">*</span></label>
                                <div class="col-sm-6">                                       
                                    <textarea name="answer" class="summernote"></textarea>
                                </div>             
                            </div>   

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Status<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="status" class="form-control form-control-default required select2" required>                                            
                                        <option value="">Select</option>                                            
                                        <option value="Active">Active</option>                                            
                                        <option value="Inactive">Inactive</option> 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Suggested<span class="text-danger">*</span></label>
                                <div class="col-sm-6 form-radio">
                                    <div class="radio radio-inline">
                                        <label>
                                        <input type="radio" name="suggested"  value="yes">
                                        <i class="helper"></i>Yes
                                        </label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <label>
                                        <input type="radio" name="suggested" checked="checked" value="no">
                                        <i class="helper"></i>No
                                        </label>
                                    </div>                               
                                </div>                               
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" id="createuserbtn" class="btn btn-info btn-round">Submit</button>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="{{route('admin.help')}}" class="btn btn-default btn-round">Cancel</a>
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
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });					
        
        $('.summernote').summernote({
            height: 300
        });
        $('.select2').select2();

        $(document).on('change','#category', function(){
            getSubCategory($(this).val());
        });

        function getSubCategory(id){
            $.ajax({
                type:"POST",
                url: "/admin/ajax_help_subcategory/" + id,							
                success: function(result){                 
                  
                    if(result.status == '1'){					
                        var html = '<option value="">Select Sub Category</option>';
                        for(var i = 0; i < result.data.length; i++){							
                            var item = result.data[i];
                                html += '<option value="'+item.id+'">'+item.name+'</option>';                               
                        }
                        console.log(html);					
                        $('#subcategory').html(html);
                        $('#subcategory').select2();						
                    }else{
                        console.log("Connect Error!");
                    }
                }
            });
        }
    });
 </script>

@stop