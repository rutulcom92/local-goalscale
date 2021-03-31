<div class="form_field_cls">
  	<div class="full_width">
      	<div class="row">
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('First Name *') }}
          			{{ Form::text('users[first_name]', isset($provider->first_name) ? $provider->first_name : null, array('class'=>'input_control','placeholder'=>'First name'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Last Name *') }}
          			{{ Form::text('users[last_name]', isset($provider->last_name) ? $provider->last_name : null, array('class'=>'input_control','placeholder'=>'Last name'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
            <div class="form-group">
                {{ Form::label('Organization *') }}
                    <input type="hidden" name="org_id" value="{{ $org_id }}" id="org_id">
                    <select name="users[organization_id]" data-placeholder="Please Select"  class="element_select provider_organization" data-get-provider-programs-ajax-url = {{route("provider.get-organization-programs") }} >
                       	<option value="0">Please Select</option>
                        @foreach($organizations as $key => $val)
                            @if($key == $org_id)
                                <option value="{{$key}}" selected="selected">{{$val}}</option>
                            @elseif($key == $selected_organization)
                                <option value="{{$key}}" selected="selected">{{$val}}</option>
                            @else
                                <option value="{{$key}}">{{$val}}</option>
                            @endif
                        @endforeach
                    </select>
              </div>
      		</div>
  		</div>
  	</div>
  	<div class="full_width">
      	<div class="row">
      		<div class="col-sm-3">
          		<div class="form-group">
                {{ Form::label('Provider Type *') }}
                {{ Form::select('userDetail[provider_type_id]', [' ' => 'Please Select']+ $provider_types->toArray(), isset($providerDetail->provider_type_id) ? $providerDetail->provider_type_id : null ,array('class' => 'element_select provider_type sel_providerType', empty($provider->id) && empty($providerDetail->provider_type_id) ? 'disabled' : '' )) }}
              </div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label(isset($organization->program_label) ? $organization->program_label.' *' : 'Program *') }}
                    <input type="hidden" name="pid" value="{{ $pid }}" id="pid">
                    <select name="user_programs[program_id][]" class="multi_select_element sel_programs provider_programs" multiple="multiple" data-tags="true" data-placeholder="Please Select" data-get-provider-supervisors-ajax-url = {{route("provider.get-programs-supervisors") }} {{ empty($provider->id) && empty($selected_programs) ? 'disabled' : '' }}>
                        @foreach($programs as $key => $val)
                        @if($key == $pid)
                            <option value="{{$key}}" selected="selected">{{$val}}</option>
                            @elseif(in_array($key,$selected_programs))
                                <option value="{{$key}}" selected="selected">{{$val}}</option>
                            @else
                                <option value="{{$key}}">{{$val}}</option>
                            @endif
                        @endforeach
                    </select>
          		</div>
      		</div>
      	</div>
  	</div>
	<div class="full_width">
		<div class="row select-supervisors">
			@if(!isset($id))
				<div class="col-sm-3">
					<div class="form-group">
					{{ Form::label(isset($organization->supervisor_label) ? $organization->supervisor_label.' *' : 'Supervisor *') }}
						<select name="provider_supervisor[supervisor_id][]" class="multi_select_element select2-element sel_supervisor" id="provider_supervisor_0" placeholder="Please Select" multiple="multiple">
							<option value="">Please Select</option>
							@foreach($supervisors as $key => $val)
								<option value="{{$key}}">{{$val}}</option>
							@endforeach
					</select>
					</div>
				</div>
			@else
				@foreach($supervisors as $key => $val) 
				<div class="col-sm-3">
					<div class="form-group">
					{{ Form::label(isset($organization->supervisor_label) ? $organization->supervisor_label .' : '. $val['program_name'].' *' : 'Supervisor : '. $val['program_name'].' *') }}
					<select name="provider_supervisor[supervisor_id][]" class="multi_select_element select2-element sel_supervisor" placeholder="Please Select" id="provider_supervisor_{{$val['program_id']}}" multiple="multiple">
						<option value="">Please Select</option>
						@foreach($val['data'] as $key1 => $supervisor)
                            @if(!empty($selected_supervisor->where('program_id',$val['program_id'])->where('supervisor_id',$supervisor->id)->first()))
                                <option selected="selected" value="{{$supervisor->id}},{{$val['program_id']}}">{{$supervisor->full_name}}</option>
                            @else
                                <option value="{{$supervisor->id}},{{$val['program_id']}}">{{$supervisor->full_name}}</option>
                            @endif
						@endforeach
					</select>
					</div>
				</div>
				@endforeach

			@endif
		</div>
	</div>
  	<div class="full_width">
      	<div class="row">
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Email *') }}
          			{{ Form::text('users[email]', isset($provider->email) ? $provider->email : null, array('class'=>'input_control','id' => 'providerEmail','placeholder'=>'Email'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Phone *') }}
          			{{ Form::text('users[phone]', isset($provider->phone) ? $provider->phone : null, array('class'=>'input_control mobile-input-mask','placeholder'=>'Phone'))}}
          		</div>
      		</div>
      	</div>
  	</div>
  	<div class="full_width">
  		<div class="row">
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Address *') }}
          			{{ Form::text('users[address]', isset($provider->address) ? $provider->address : null, array('class'=>'input_control','placeholder'=>'Address'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('City *') }}
          			{{ Form::text('users[city]', isset($provider->city) ? $provider->city : null, array('class'=>'input_control','placeholder'=>'City'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
      			{{ Form::label('State *') }}
      			{{ Form::select('users[state_id]', ['' => 'Please Select']+ $states->toArray(), isset($provider->state_id) ? $provider->state_id : null ,array('class' => 'element_select')) }}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Zip *') }}
          			{{ Form::text('users[zip]', isset($provider->zip) ? $provider->zip : null, array('class'=>'input_control zip-input-mask','placeholder'=>'Zip'))}}
          		</div>
      		</div>
  		</div>
  	</div>
  	<div class="full_width">
  		<div class="row">
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Record # (enter N/A if not applicable)*') }}
          			{{ Form::text('users[record_num]', isset($provider->record_num) ? $provider->record_num : 0, array('class'=>'input_control','placeholder'=>'Record'))}}
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
                  <input type="password" name ="users[password]" class="input_control marg13" placeholder="New password"  autocomplete="new-password">
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
                                  <input type="checkbox" class="custom-control-input business_To p_view " name="inactive_user" value="1" @if($provider->is_active == 0) checked="" @endif>
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
