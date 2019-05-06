@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                    <h4>Referral Setting Manage</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item">Referral Setting</li>                     
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
                                <h5>Referral Setting Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{url('admin/referral_settings')}}"  accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                                {{ csrf_field() }}
                            @foreach($referralsettings as $ref)
                                @if($ref->name != "currency_code")
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label text-right">{{$ref->name}}<span class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" name="{{$ref->name}}" value="{{$ref->value}}" class="form-control"  required>
                                    </div>
                                </div>
                                @else                                
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Currency<span class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                            <select name="currency_code" class="form-control form-control-default required" required>                                            
                                                @foreach($currencies as $cur)                                          
                                                    <option value="{{$cur->code}}" <?php echo $cur->code==$ref->currency_code?"selected":"";?>>{{$cur->code}}</option>
                                                @endforeach 
                                            </select>
                                        </div>
                                    </div>
                               
                                @endif
                            @endforeach            

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
 
@stop