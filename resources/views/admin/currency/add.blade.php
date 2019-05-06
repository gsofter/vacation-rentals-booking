@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                    <h4>Currency Manage</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.currency')}}">Currency</a></li>
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
                                <h5>Add Currency Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{url('admin/add_currency')}}"  accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                                {{ csrf_field() }}

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Name<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="name" class="form-control"  placeholder="Name" required>
                                </div>
                            </div>                                          
                                                                  
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Code<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="code" class="form-control"  placeholder="Code" required>
                                </div>
                            </div>                                          
                                                                  
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Symbol<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="symbol" class="form-control"  placeholder="Symbol" required>
                                </div>
                            </div>                                          
                                                                  
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Rate<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="number" name="rate" class="form-control" step="0.01" placeholder="Rate" required>
                                </div>
                            </div>                                          
                                                                  
                           
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Status<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="status" class="form-control form-control-default required" required>                                            
                                        <option value="">Select</option>                                            
                                        <option value="Active">Active</option>                                            
                                        <option value="Inactive">Inactive</option> 
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" id="createuserbtn" class="btn btn-info btn-round">Submit</button>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="{{route('admin.currency')}}" class="btn btn-default btn-round">Cancel</a>
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