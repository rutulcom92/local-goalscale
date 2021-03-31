<div class="form_field_cls">
  	<div class="full_width">
      	<div class="row">
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('First Name') }}
          			{{ Form::text('users[first_name]', isset($provider->first_name) ? $provider->first_name : null, array('class'=>'input_control','placeholder'=>'First name'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Last Name') }}
          			{{ Form::text('users[last_name]', isset($provider->last_name) ? $provider->last_name : null, array('class'=>'input_control','placeholder'=>'Last name'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Provider Type') }}
          			{{ Form::select('userDetail[provider_type_id]', [' ' => 'Please Select']+ $provider_types->toArray(), isset($providerDetail->provider_type_id) ? $providerDetail->provider_type_id : null ,array('class' => 'element_select provider_type')) }}
          		</div>
      		</div>
  		</div>
  	</div>
  	<div class="full_width">
      	<div class="row">
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Email') }}
          			{{ Form::text('users[email]', isset($provider->email) ? $provider->email : null, array('class'=>'input_control','id' => 'providerEmail','placeholder'=>'Email'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Phone') }}
          			{{ Form::text('users[phone]', isset($provider->phone) ? $provider->phone : null, array('class'=>'input_control mobile-input-mask','placeholder'=>'Phone'))}}
          		</div>
      		</div>
      	</div>
  	</div>
  	<div class="full_width">
  		<div class="row">
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Address') }}
          			{{ Form::text('users[address]', isset($provider->address) ? $provider->address : null, array('class'=>'input_control','placeholder'=>'Address'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('City') }}
          			{{ Form::text('users[city]', isset($provider->city) ? $provider->city : null, array('class'=>'input_control','placeholder'=>'City'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
      			{{ Form::label('State') }}
      			{{ Form::select('users[state_id]', ['' => 'Please Select']+ $states->toArray(), isset($provider->state_id) ? $provider->state_id : null ,array('class' => 'element_select')) }}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Zip') }}
          			{{ Form::text('users[zip]', isset($provider->zip) ? $provider->zip : null, array('class'=>'input_control zip-input-mask','placeholder'=>'Zip'))}}
          		</div>
      		</div>
  		</div>
  	</div>
  	<div class="full_width">
  		<div class="row">
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Record #') }}
          			{{ Form::number('users[record_num]', isset($provider->record_num) ? $provider->record_num : null, array('class'=>'input_control','placeholder'=>'Record'))}}
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
                            <input type="checkbox" class="custom-control-input business_To p_view " name="inactive_user" value="1" @if($provider->is_active == 0) checked="" @endif>
                            <span class="custom-control-indicator"></span>
                            <div class="custom-control-description">User Inactive</div>
                        </label>
                    </div>
                </div>
          </div>
        </div>
    </div>
</div>