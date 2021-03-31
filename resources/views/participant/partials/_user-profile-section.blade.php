<div class="form_field_cls">
  	<div class="full_width">
      	<div class="row">
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('First Name') }}
          			{{ Form::text('users[first_name]', isset($participant->first_name) ? $participant->first_name : null, array('class'=>'input_control','placeholder'=>'First name'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Last Name') }}
          			{{ Form::text('users[last_name]', isset($participant->last_name) ? $participant->last_name : null, array('class'=>'input_control','placeholder'=>'Last name'))}}
          		</div>
      		</div>
          @foreach($selected_provider as $key => $val)
                <div class="col-sm-3">
                  <div class="form-group">
                    {{ Form::label($val['program_name'].' Provider *') }}
                    <div class="input_control">{{$val->provider->full_name}}</div>
                </div>
              </div>
            @endforeach
      		</div>
      	</div>
  	<div class="full_width">
      	<div class="row">
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Email') }}
          			{{ Form::text('users[email]', isset($participant->email) ? $participant->email : null, array('class'=>'input_control','id'=>'participantEmail','placeholder'=>'Email'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Phone') }}
          			{{ Form::text('users[phone]', isset($participant->phone) ? $participant->phone : null, array('class'=>'input_control mobile-input-mask','placeholder'=>'Phone'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Date of Birth','Date of Birth') }}
          			{{ Form::text('userDetail[dob]', isset($participantDetail->dob) ? mdyDateFormate($participantDetail->dob) : null, array('class'=>'input_control dob-datepicker-element'))}}
          		</div>
      		</div>
      	</div>
  	</div>
  	<div class="full_width">
  		<div class="row">
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Address') }}
          			{{ Form::text('users[address]', isset($participant->address) ? $participant->address : null, array('class'=>'input_control','placeholder'=>'Address'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('City') }}
          			{{ Form::text('users[city]', isset($participant->city) ? $participant->city : null, array('class'=>'input_control','placeholder'=>'City'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
      			{{ Form::label('State') }}
      			{{ Form::select('users[state_id]', ['' => 'Please Select']+ $states->toArray(), isset($participant->state_id) ? $participant->state_id : null ,array('class' => 'element_select')) }}
          		</div>
      		</div>
  		</div>
  	</div>
  	<div class="full_width">
  		<div class="row">
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Zip') }}
          			{{ Form::text('users[zip]', isset($participant->zip) ? $participant->zip : null, array('class'=>'input_control zip-input-mask','placeholder'=>'Zip'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Record # (add N/A if not applicable)') }}
                {{ Form::text('users[record_num]', isset($participant->record_num) ? $participant->record_num : 0, array('class'=>'input_control','placeholder'=>'Record'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Gender') }}
          			<div class="full_width">
              			<div class="half_radio_cl">
                          <div class="custom_radio">
                           {{ Form::radio('userDetail[gender]','M',isset($participantDetail->gender) ? ($participantDetail->gender == "M") ? "checked" : "" : "",array('id' => 'test6'))}}
                            <label for="test6">Male</label>
                          </div>
                    	</div>
                    	<div class="half_radio_cl">
                          <div class="custom_radio">
                           {{ Form::radio('userDetail[gender]','F',isset($participantDetail->gender) ? ($participantDetail->gender == "F") ? "checked" : "" : "",array('id' => 'test7'))}}
                            <label for="test7">Female</label>
                          </div>
                    	</div>
                    	<div class="half_radio_cl">
                          <div class="custom_radio">
                            {{ Form::radio('userDetail[gender]','O', isset($participantDetail->gender) ? ($participantDetail->gender == "O") ? "checked" : "" : "",array('id' => 'test8'))}}
                            <label for="test8">Other</label>
                          </div>
                    	</div>
                	</div>
                	<span id="gendor_error"></span>
          		</div>
      		</div>
  		</div>
  	</div>
  	<div class="full_width separator_div"></div>
  	<div class="full_width forgot_pass">
  		<div class="row">
  			<div class="col-sm-3">
          		<h6>Set Password</h6>
          		<div class="form-group marg13">
          			{{ Form::label('Set Password') }}
          			<input type="password" name ="users[password]" class="input_control marg13" placeholder="New password" autocomplete="new-password">
          			<input type="password" name ="password_confirmation"  class="input_control" placeholder="Confirm new password">
          		</div>
      		</div>
  		</div>
  	</div>
  	<div class="full_width">
  		<div class="row">
      		<div class="col-sm-6">
      			<div class="full_width">
              		<div class="custom-control custom-checkbox dfg ">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input business_To p_view " name="inactive_user" value="1" @if($participant->is_active == 0) checked="" @endif>
                            <span class="custom-control-indicator"></span>
                            <div class="custom-control-description">User Inactive</div>
                        </label>
                    </div>
                </div>
      		</div>
      	</div>
  	</div>
</div>