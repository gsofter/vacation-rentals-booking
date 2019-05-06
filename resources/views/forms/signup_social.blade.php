<?php

/**
 * signup_social.blade.php
 *
 * @description
 *
 * @author  Eddie Padin
 *
 * @project vacationrentals
 */
?>



<form action='{{route('social.create_social')}}' class='signup-form vr_form' data-action='Signup' id='{{$form_id ?? ""}}' accept-charset='UTF-8' novalidate='true'>
<div class="signup-form-fields">
	
	<input type='hidden' name='from' value='email_signup' id='from' />
	@switch(true)
		@case(isset($user['fb_id']))
        <input type='hidden' name='fb_id' value='{{$user['fb_id']}}' id='fb_id' />
		
		@break
		@case(isset($user['google_id']))
        <input type='hidden' name='google_id' value='{{$user['google_id']}}' id='google_id' />
		
		@break
		@case(isset($user['linkedin_id']))
        <input type='hidden' name='linkedin_id' value='{{$user['linkedin_id']}}' id='linkedin_id' />
		
		@break
		@default
        <input type='hidden' name='social_id'  id='social_id' />
		
	@endswitch
	
	@if(isset($user['avatar']))
    <input type='hidden' name='avatar' value='{{$user['avatar']}}'  id='avatar' />
		
	@endif
	
	<input type='hidden' name='ip_address' value='{{request()->ip()}}'  id='ip_address{{$input_id ?? ''}}' />
	<div class="control-group row-space-1" id="inputFirst">
		@if ($errors->has('first_name'))
			<div class="help-block-container">
				<div class="help-block">{{ $errors->first('first_name') }}</div>
			</div>
		@endif
        <input type='text' name='first_name' value='{{$user['first_name']}}' class='{{$errors->has('first_name') ? 'decorative-input invalid ' : 'decorative-input name-icon'}}' placeholder='{{trans('messages.login.first_name')}}'/>
		
	</div>
	<div class="control-group row-space-1" id="inputLast">
		@if ($errors->has('last_name'))
			<div class="help-block-container">
				<div class="help-block">{{ $errors->first('last_name') }}</div>
			</div>
		@endif
		
        <input type='text' name='last_name' value='{{$user['last_name']}}' class='{{$errors->has('last_name') ? 'decorative-input invalid ' : 'decorative-input name-icon'}}' placeholder='{{trans('messages.login.last_name')}}'/>
	</div>
	<div class="row">
		<div class="col-6">
			<div class="control-group row-space-2 field_ico" id="inputPhone">
				@if ($errors->has('phone_number'))
					<div class="help-block-container">
						
						<div class="help-block">{{ $errors->first('phone_number') }}</div>
					</div>
				@endif
				<div class="pos_rel">
                <input type='tel' name='phone_number' value='{{ old('phone_number') ? old('phone_number') : '' }}' required class='{{ $errors->has('phone_number') ? 'decorative-input inspectletIgnore ' : 'decorative-input inspectletIgnore name-phone name-icon input_new' }}' id='phone_number{{$input_id ?? ''}}' '/>
				
					<span id="valid-msg" class="hide pull-right mb-3 valid-msg">✓ Valid</span>
					<span id="error-msg" class="hide pull-right mb-3 error-msg">Invalid number</span>
                    <input type='hidden' name='phone_code' value='{{old('phone_code') ? old('phone_code') : 'us'}}' id='phone_code{{$input_id ?? ''}}' />
					
				</div>
			</div>
		</div>
		<div class="col-6">
			<div class="control-group row-space-1" id="inputEmail">
				@if ($errors->has('email'))
					<div class="help-block-container">
						
						<div class="help-block">{{ $errors->first('email') }}</div>
					</div>
				@endif
                <input type='email' value='{{$user['email']}}' class='{{$errors->has('email') ? 'decorative-input inspectletIgnore invalid' : 'decorative-input inspectletIgnore name-mail name-icon'}}' placeholder='{{trans('messages.login.email_address')}}'/>
				
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="control-group row-space-top-3 row-space-2 ">
				<p class="h4 row-space-1">{{ trans('messages.login.birthday') }}</p>
				<p class="let_sp">{{  trans('messages.login.birthday_message') }}</p>
			</div>
			<div class="control-group row-space-1 " id="inputBirthday"></div>
			@if ($errors->has('birthday_month') || $errors->has('birthday_day') || $errors->has('birthday_year'))
				<div class="help-block-container">
					<div class="help-block"> {{ $errors->has('birthday_day') ? $errors->first('birthday_day') : ( $errors->has('birthday_month') ? $errors->first('birthday_month') : $errors->first('birthday_year') ) }} </div>
				</div>
			@endif
			<div class="control-group row-space-2 calander_new">
				<label class="select month drp_dwn_cng">
					<i class="icon-chevron-down"></i>
                    {{ trans('messages.header.month')}}
                    <select class="form-control {{$errors->has('birthday_month') ? 'birthday_group invalid' : 'birthday_group'}}" name="birthday_month" id='user_birthday_month{{$input_id ?? ''}}'>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
					
				</label>
				<label class="select day month drp_dwn_cng">
					<i class="icon-chevron-down"></i>
                    {{trans('messages.header.day')}}
                    
					<select name='birthday_day' class="form-control {{$errors->has('birthday_day') ? 'birthday_group invalid' : 'birthday_group'}}" id='user_birthday_day{{$input_id ?? ''}}'>
                @for($i=1; $i<=31; $i++)
                <option value="{{$i}}">{{$i}}</option>
                @endfor
                </select>
				</label>
                
				<label class="select year month drp_dwn_cng">
					<i class="icon-chevron-down"></i>
                    {{trans('messages.header.year')}}
				
                    <select name='birthday_day' class="form-control {{$errors->has('birthday_year') ? 'birthday_group invalid' : 'birthday_group'}}" id='user_birthday_year{{$input_id ?? ''}}'>
                @for($i=date('Y')-120; $i<=date('Y'); $i++)
                <option value="{{$i}}">{{$i}}</option>
                @endfor
                </select>
				</label>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="control-group row-space-top-3 row-space-2 ">
				<p class="h4 row-space-1">{{  trans('messages.login.user_type_title') }} : </p>
			</div>
			<div class="control-group row-space-2 field_ico" id="inputUserType">
				<div class="row">
					<div class="col-12 col-md-4">
						@if ($errors->has('user_type'))
							<div class="help-block-container">
								<div class="help-block">{{ $errors->first('user_type') }}</div>
							</div>
						@endif
						<input type="radio" name='user_type' id="box-1{{ ($input_id ?? '') }}" value="host" class="user_type_group">
						<label for="box-1{{ ($input_id ?? '') }}">{{  trans('messages.login.user_type_listing') }}</label>
					</div>
					<div class="col-12 col-md-4">
						<input type="radio" name='user_type' id="box-2{{ ($input_id ?? '') }}" value="guest" class="user_type_group" checked>
						<label for="box-2{{ ($input_id ?? '') }}">{{  trans('messages.login.user_type_booking') }}</label>
					</div>
					<div class="col-12 col-md-4">
						<input type="radio" name='user_type' id="box-3{{ ($input_id ?? '') }}" value="both" class="user_type_group">
						<label for="box-3{{ ($input_id ?? '') }}">{{  trans('messages.login.user_type_both') }}</label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-12">
			<div id="tos_outside" class="row-space-top-2 chk-box">
				<div class="dis_tb control-group">
					<div class="dis_cell">
						<input  type="checkbox" name="agree_tac" id="agree_tac{{ ($input_id ?? '') }}" required>
					</div>
					<div class="dis_cell">
						<small>
							{{ trans('messages.login.signup_agree') }} Vacation.rental's <a href="{{URL::to('/')}}/terms_of_service" data-popup="true">{{ trans('messages.login.terms_service') }}</a>, <a href="{{URL::to('/')}}/privacy_policy" data-popup="true">{{ trans('messages.login.privacy_policy') }}</a>.
						</small>
					</div>
				</div>
			</div>
		</div>
	</div>
	@switch(true)
		@case(isset($user['fb_id']))
		<p class="text-center">{{trans('messages.login.info_from_fb')}}</p>
		@break
		@case(isset($user['google_id']))
		<p class="text-center">{{trans('messages.login.info_from_google')}}</p>
		@break
		@case(isset($user['linkedin_id']))
		<p class="text-center">{{trans('messages.login.info_from_linkedin')}}</p>
		@break
		@default
		<p class="text-center">{{trans('messages.login.info_from_social')}}</p>
	@endswitch
	
	<div class="control-group row-space-top-3 row-space-1">
    <button class='btn btn-primary btn-block btn-large' id='' style='float:none;'>{{trans("messages.login.finish_signup")}}</button>
		
	</div>
</div>
</form>