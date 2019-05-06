@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                    <h4>Send Email Manage</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Send Email</a></li>                     
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
                                <h5>Send Email Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{url('admin/send_email')}}"  accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                                {{ csrf_field() }}

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Email To<span class="text-danger">*</span></label>
                                <div class="col-sm-6 form-radio">
                                    <div class="radio radio-inline">
                                        <label>
                                        <input type="radio" name="selectuser"  value="all">
                                        <i class="helper"></i>All
                                        </label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <label>
                                        <input type="radio" name="selectuser" checked="checked" value="specific">
                                        <i class="helper"></i>Specific
                                        </label>
                                    </div>                               
                                </div>                               
                            </div>                                  
                            <div class="form-group row" id="emailaddress">
                                <label class="col-sm-3 col-form-label text-right">Email Address</label>
                                <div class="col-sm-6">
                                    <input type="email" name="email_address" class="form-control"  placeholder="Email address" required>
                                </div>
                            </div>  
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Subject<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="subject" class="form-control"  placeholder="Subject" required>
                                </div>
                            </div>   

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Message<span class="text-danger">*</span></label>
                                <div class="col-sm-6">                                       
                                    <textarea name="message" class="summernote"></textarea>
                                </div>             
                            </div>   


                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" id="createuserbtn" class="btn btn-info btn-round">Submit</button>                                   
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
       
        $('input[type=radio][name=selectuser]').change(function() {
            if (this.value == 'all') {
                $('#emailaddress label').css('display', 'none');
                $('#emailaddress input').css('display', 'none');
                
            }
            else{
                $('#emailaddress label').css('display', 'block');
                $('#emailaddress input').css('display', 'block');
            }
        });

        
    });
 </script>

@stop