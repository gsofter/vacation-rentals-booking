@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                    <h4>Subscription Plan Manage</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.subscriptions_plan')}}">Subscription Plan</a></li>
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
                                <h5>Edit Subscription Plan Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{url('admin/edit_subscription_plan/'.$subscription->id)}}" accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$subscription->id}}" name="id">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Plan Type<span class="text-danger">*</span></label>
                                <div class="col-sm-6 form-radio">
                                    <div class="radio radio-inline">
                                        <label>
                                        <input type="radio" name="plan_type"  value="Paid" <?php echo $subscription->plan_type=="Paid"?"checked":"";?>>
                                        <i class="helper"></i>Pain Plan
                                        </label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <label>
                                        <input type="radio" name="plan_type" <?php echo $subscription->plan_type=="Free"?"checked":"";?> value="Free">
                                        <i class="helper"></i>Free Plan
                                        </label>
                                    </div>                               
                                </div>                               
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Name<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="name" class="form-control" value="{{$subscription->name}}" placeholder="name" required>
                                </div>
                            </div>   
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Stripe Plan Code</label>
                                <div class="col-sm-6">
                                    <input type="text" name="stripe_plan_code" class="form-control" value="{{$subscription->stripe_plan_code}}"  placeholder="Stripe Plan Code">
                                </div>
                            </div>   
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Braintree Plan Code</label>
                                <div class="col-sm-6">
                                    <input type="text" name="braintree_plan_code" class="form-control" value="{{$subscription->braintree_plan_code}}"  placeholder="Braintree Plan Code">
                                </div>
                            </div>   

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Trial Days</label>
                                <div class="col-sm-6">
                                    <input type="number" name="trial_days" min="0" value="{{$subscription->trial_days}}" class="form-control">
                                </div>
                            </div>   

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Currency Code<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="currency_code"  class="form-control form-control-default required select2" required>                                            
                                        <option value="">Select</option>
                                        @foreach($currencies as $cur)            
                                            <option value="{{$cur->id}}"  <?php echo $cur->id==$subscription->currency_code?"selected":"";?>>{{$cur->code}}</option> 
                                        @endforeach
                                    </select>
                                </div>
                            </div>                                                                     
                                                        
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Amount<span class="text-danger">*</span></label>
                                <div class="col-sm-6 input-group">                   
                                    <span class="input-group-addon" id="basic-addon1">$</span>
                                    <input type="text" class="form-control"  value="{{$subscription->amount}}" name="amount">                                    
                                </div>
                            </div>    

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Billing Period<span class="text-danger">*</span></label>
                                <div class="col-sm-3">    
                                    <input type="number" class="form-control" min="1" value="{{$subscription->days}}"  name="days">                                    
                                </div>
                                <div class="col-sm-3">
                                    <select name="period" class="form-control form-control-default required" required>   
                                        <option value="1">Day</option>                                            
                                        <option value="7">Week</option> 
                                        <option value="30">Month</option> 
                                        <option value="365">Year</option> 
                                    </select>
                                </div>
                            </div>     

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Upload Image Limit<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="number" name="images" min="1" value="{{$subscription->images}}" class="form-control"   required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Status<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="status" class="form-control form-control-default required" required>                                            
                                        <option value="">Select</option>                                            
                                        <option value="Active" <?php echo $subscription->status=="Active"?"selected":"";?>>Active</option>                                            
                                        <option value="Inactive" <?php echo $subscription->status=="Inactive"?"selected":"";?>>Inactive</option> 
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" id="createuserbtn" class="btn btn-info btn-round">Submit</button>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="{{route('admin.subscriptions_plan')}}" class="btn btn-default btn-round">Cancel</a>
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
    $('.select2').select2();

    $('.dropify').dropify();
 </script>
@stop