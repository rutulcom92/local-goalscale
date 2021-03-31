<div class="form_field_cls">
	<div class="full_width">
  	<div class="row">
  		<div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label('First Name') }}
      			{{ Form::text('users[first_name]', isset($supervisor->first_name) ? $supervisor->first_name : null, array('class'=>'input_control','placeholder'=>'First name'))}}
      		</div>
  		</div>
  		<div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label('Last Name') }}
      			{{ Form::text('users[last_name]', isset($supervisor->last_name) ? $supervisor->last_name : null, array('class'=>'input_control','placeholder'=>'Last name'))}}
      		</div>
  		</div>
  	</div>
	</div>
	<div class="full_width">
  	<div class="row">
  		<div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label('Email') }}
      			{{ Form::text('users[email]', isset($supervisor->email) ? $supervisor->email : null, array('class'=>'input_control','id'=>'supervisorEmail', 'placeholder'=>'Email'))}}
      		</div>
  		</div>
  		<div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label('Phone') }}
      			{{ Form::text('users[phone]', isset($supervisor->phone) ? $supervisor->phone : null, array('class'=>'input_control mobile-input-mask','placeholder'=>'Phone'))}}
      		</div>
  		</div>
  	</div>
	</div>
	<div class="full_width">
		<div class="row">
  		<div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label('Address') }}
      			{{ Form::text('users[address]', isset($supervisor->address) ? $supervisor->address : null, array('class'=>'input_control','placeholder'=>'Address'))}}
      		</div>
  		</div>
  		<div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label('City') }}
      			{{ Form::text('users[city]', isset($supervisor->city) ? $supervisor->city : null, array('class'=>'input_control','placeholder'=>'City'))}}
      		</div>
  		</div>
  		<div class="col-sm-3">
      		<div class="form-group">
  			{{ Form::label('State') }}
  			{{ Form::select('users[state_id]', ['' => 'Please Select']+ $states->toArray(), isset($supervisor->state_id) ? $supervisor->state_id : null ,array('class' => 'element_select')) }}
      		</div>
  		</div>
  		<div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label('Zip') }}
      			{{ Form::text('users[zip]', isset($supervisor->zip) ? $supervisor->zip : null, array('class'=>'input_control zip-input-mask','placeholder'=>'Zip'))}}
      		</div>
  		</div>
		</div>
	</div>
	<div class="full_width">
		<div class="row">
  		<div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label('Record #') }}
      			{{ Form::number('users[record_num]', isset($supervisor->record_num) ? $supervisor->record_num : null, array('class'=>'input_control','placeholder'=>'Record'))}}
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
                            <input type="checkbox" class="custom-control-input business_To p_view " name="inactive_user" value="1" @if($supervisor->is_active == 0) checked="" @endif>
                            <span class="custom-control-indicator"></span>
                            <div class="custom-control-description">User Inactive</div>
                        </label>
                    </div>
                </div>
          </div>
        </div>
    </div>
</div> 