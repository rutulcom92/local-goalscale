<div class="form_field_cls">
	<div class="full_width">
  	<div class="row">
  		<div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label('First Name *') }}
      			{{ Form::text('users[first_name]', isset($supervisor->first_name) ? $supervisor->first_name : null, array('class'=>'input_control','placeholder'=>'First name'))}}
      		</div>
  		</div>
  		<div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label('Last Name *') }}
      			{{ Form::text('users[last_name]', isset($supervisor->last_name) ? $supervisor->last_name : null, array('class'=>'input_control','placeholder'=>'Last name'))}}
      		</div>
  		</div>
  	</div>
	</div>
	<div class="full_width">
  	<div class="row">
  		<div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label('Organization *') }}
      			{{ Form::select('users[organization_id]', ['' => 'Please Select']+ $organizations->toArray(), isset($supervisor->organization_id) ? $supervisor->organization_id : (isset($org_id) ? $org_id : null) ,array('class' => 'element_select supervisor_organization','data-get-spervisor-programs-ajax-url' => route('supervisor.get-organization-programs'))) }}
      		</div>
  		</div>
  		<div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label(isset($organization->program_label) ? $organization->program_label.' *' : 'Program *') }}
				<select name="user_programs[program_id][]" class="multi_select_element sel_programs" multiple="multiple" data-tags="true", data-placeholder="Please Select">
					@foreach($programs as $key => $val)
						@if(in_array($key,$selected_programs))
							<option value="{{$key}}" selected="selected">{{$val}}</option>
						@else
							<option value="{{$key}}">{{$val}}</option>
						@endif
					@endforeach
				</select>
      		</div>
  		</div>
  		<!-- <div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label('Role *') }}
      			{{ Form::select('userss[role_id]', array('' => 'Please Select', '1' => 'Role 1', '2' => 'Role 2'), isset($supervisor->role_id) ? $supervisor->role_id : null ,array('class' => 'element_select')) }}
      		</div>
  		</div> -->
  	</div>
	</div>
	<div class="full_width">
  	<div class="row">
  		<div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label('Email *') }}
      			{{ Form::text('users[email]', isset($supervisor->email) ? $supervisor->email : null, array('class'=>'input_control','id'=>'supervisorEmail', 'placeholder'=>'Email'))}}
      		</div>
  		</div>
  		<div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label('Phone *') }}
      			{{ Form::text('users[phone]', isset($supervisor->phone) ? $supervisor->phone : null, array('class'=>'input_control mobile-input-mask','placeholder'=>'Phone'))}}
      		</div>
  		</div>
  	</div>
	</div>
	<div class="full_width">
		<div class="row">
  		<div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label('Address *') }}
      			{{ Form::text('users[address]', isset($supervisor->address) ? $supervisor->address : null, array('class'=>'input_control','placeholder'=>'Address'))}}
      		</div>
  		</div>
  		<div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label('City *') }}
      			{{ Form::text('users[city]', isset($supervisor->city) ? $supervisor->city : null, array('class'=>'input_control','placeholder'=>'City'))}}
      		</div>
  		</div>
  		<div class="col-sm-3">
      		<div class="form-group">
  			{{ Form::label('State *') }}
  			{{ Form::select('users[state_id]', ['' => 'Please Select']+ $states->toArray(), isset($supervisor->state_id) ? $supervisor->state_id : null ,array('class' => 'element_select')) }}
      		</div>
  		</div>
  		<div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label('Zip *') }}
      			{{ Form::text('users[zip]', isset($supervisor->zip) ? $supervisor->zip : null, array('class'=>'input_control zip-input-mask','placeholder'=>'Zip'))}}
      		</div>
  		</div>
		</div>
	</div>
	<div class="full_width">
		<div class="row">
			<div class="col-sm-3">
				<div class="form-group">
					{{ Form::label('Record # (enter N/A if not applicable)*') }}
					{{ Form::text('users[record_num]', isset($supervisor->record_num) ? $supervisor->record_num : 0, array('class'=>'input_control','placeholder'=>'Record'))}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					{{ Form::label('Race/Ethnicity') }}
					{{ Form::select('users[ethnicity]', ['' => 'Please Select','American Indian Or Alaska Native' => 'American Indian Or Alaska Native','Asian' => 'Asian','Black Or African American' => 'Black Or African American','Hispanic Or Latino' => 'Hispanic Or Latino','I Don\'t Wish To Answer' => 'I Don\'t Wish To Answer','Native Hawaiian Or Other Pecific Islander' => 'Native Hawaiian Or Other Pecific Islander','Two Or More Races' => 'Two Or More Races','White' => 'White'], isset($supervisor->ethnicity) ? $supervisor->ethnicity : null ,array('class' => 'element_select')) }}
				</div>
			</div>
		</div>
	</div>
	<div class="full_width separator_div"></div>
      @if(isset($id))
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
          @if(Auth::user()->isSuperAdmin() == true  || Auth::user()->isOrganizationAdmin())
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
          @endif
       @else
          <div class="full_width">
            <div class="row">
              <div class="col-sm-6">
                <div class="full_width">
                  <div class="custom-control custom-checkbox dfg ">
                      <label class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input business_To p_view " name="user_set_password" value="1" checked="">
                          <span class="custom-control-indicator"></span>
                          <div class="custom-control-description">Send the new user an email about their account and a password reset link</div>
                      </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
      @endif

</div> 