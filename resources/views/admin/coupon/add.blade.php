@extends('layouts/admin')
@section('admin-content')        
@include('admin/common/side')	

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="page-header-title">
                  <h4>Add Coupon Code</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{route('admin.dashboard')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item"><a href="#">Pages</a></li>
                     <li class="breadcrumb-item"><a href="{{route('admin.coupon')}}">Coupon Code</a></li>
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
                                <h5>Add Coupon Code Form</h5>
                            </div>                          
                            <div class="col-sm-3 text-right">
                                <span class="text-danger">(*)Fields are Mandatory</span>
                            </div>                          
                        </div>                          
                        
                        
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{url('admin/add_coupon_code')}}" accept-charset="UTF-8" class="form-horizontal bordered" role="form">
                                {{ csrf_field() }}
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Description<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="description" class="form-control" placeholder="Description" required>
                                </div>
                            </div>
                            {{--  <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Stripe Coupon Code<span class="text-danger" >*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="stripe_coupon_code" class="form-control" placeholder="Stripe Coupon Code" required>
                                </div>
                            </div>                              --}}
                            {{--  <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Braintree Coupon Code<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="braintree_coupon_code" class="form-control" placeholder="Braintree Coupon Code" required>
                                </div>
                            </div>
                              --}}
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Amount<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input class="form-control" placeholder="0.00" name="amount" type="number" value="" step="0.01">
                                </div>
                            </div>
                            

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Type<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="type" class="form-control form-control-default" required>
                                        <option>Select</option>
                                        <option value="percent_off">%</option>                                            
                                        {{--  <option value="amount_off">$</option>   --}}
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Duration<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="duration" id="duration" class="form-control form-control-default" required>
                                        <option>Select</option>
                                        <option value="once">One Time</option>                                            
                                        <option value="forever">Forever</option> 
                                        {{--  <option value="repeating">Repeating</option>   --}}
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" id="duration_in_months_div" style="display:none;">
                                <label class="col-sm-3 col-form-label text-right">Duration In Months<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input class="form-control required" placeholder="Duration In Months" id="duration_in_months" min="0" max="12" value="0" name="duration_in_months"  type="number"  required>
                                </div>
                            </div>

                            {{--  <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Max Uses<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input class="form-control required" placeholder="Amount" name="max_redemptions" min="1" type="number" value="">
                                </div>
                            </div>  --}}
                                
                            <!--  <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Coupon Currency<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="currency_code" class="form-control form-control-default" required>
                                    @foreach($currencys as $cur)
                                        <option value="{{$cur->code}}" <?php echo $cur->id==$coupon_currency?"selected":""; ?>>{{$cur->code}}</option> 
                                    @endforeach
                                    </select>
                                </div>
                            </div> -->
        
    
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Expire Date<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input id="dropper-default" name="expired_at" class="form-control required" type="text" placeholder="Select your date" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right">Status<span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="status" class="form-control form-control-default" required>
                                        <option>Select</option>
                                        <option value="Active">Active</option>                                            
                                        <option value="Inactive">Inactive</option> 
                                    </select>
                                </div>
                            </div>
                  

                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" id="createuserbtn" class="btn btn-info btn-round">Submit</button>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="{{route('admin.coupon')}}" class="btn btn-default btn-round">Cancel</a>
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
        $("#dropper-default").dateDropper( {
            dropWidth: 200,
            dropPrimaryColor: "#1abc9c", 
            dropBorder: "1px solid #1abc9c"
        });

        $(document).on('change', '#duration', function(){
            if($(this).val()=="repeating"){
                $('#duration_in_months_div').css('display', 'flex');                
            }else{
                $('#duration_in_months_div').css('display', 'none');
                $('#duration_in_months').val(0);
            }
        });
    </script>
 
@stop