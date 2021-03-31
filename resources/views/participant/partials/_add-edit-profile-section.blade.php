<div class="form_field_cls part_sec">
  	<div class="full_width">
      	<div class="row">
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('First Name *') }}
          			{{ Form::text('users[first_name]', isset($participant->first_name) ? $participant->first_name : null, array('class'=>'input_control','placeholder'=>'First name'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Last Name *') }}
          			{{ Form::text('users[last_name]', isset($participant->last_name) ? $participant->last_name : null, array('class'=>'input_control','placeholder'=>'Last name'))}}
          		</div>
      		</div>
      		</div>
      	</div>

		<div class="full_width">
      	<div class="row">
       	   <div class="col-sm-3">
      		<div class="form-group">
      			{{ Form::label('Organization *') }}
                <select name="users[organization_id]" placeholder="Please Select"  class="element_select participant_organization" data-get-participant-programs-ajax-url = {{route("participant.get-organization-programs") }} >
                    <option value="">Please select</option>
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
        <div class="col-sm-3">
        		<div class="form-group">
				{{ Form::label(isset($organization->program_label) ? $organization->program_label.' *' : 'Program *') }}
                    <input type="hidden" name="pid" value="{{ $pid }}" id="pid">
      				<select name="user_programs[program_id][]" class="multi_select_element sel_programs participant_programs" multiple="multiple" data-tags="true" data-placeholder="Please Select" data-get-participant-providers-ajax-url = {{route("participant.get-programs-providers") }}>
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
        <div class="row select-providers">
          @if(!isset($id))
            <div class="col-sm-3">
                <div class="form-group">
                  {{ Form::label('Provider *') }}
                    <select name="participant_provider[provider_id][]" class="select2-element sel_providers" placeholder="Please Select" id="participant_provider_0" multiple="multiple">
                        <option value="">Please Select</option>
                        @foreach($providers as $key => $val)
                            <option value="{{$key}}">{{$val}}</option>
                        @endforeach
                </select>
                </div>
            </div>
          @else
            @foreach($providers as $key => $val)
              <div class="col-sm-3">
                <div class="form-group">
                {{ Form::label($val['program_name'].' Provider *') }}
                  <select name="participant_provider[provider_id][]" class="select2-element sel_providers" placeholder="Please Select" id="participant_provider_{{$val['program_id']}}" multiple="multiple"> 
                    <option value="">Please Select</option>
                    @foreach($val['data'] as $key1 => $provider)
                      @if(!empty($selected_provider->where('program_id',$val['program_id'])->where('provider_id',$provider->id)->first()))
                        <option selected="selected" value="{{$provider->id}},{{$val['program_id']}}">{{$provider->full_name}}</option>
                      @else
                        <option value="{{$provider->id}},{{$val['program_id']}}">{{$provider->full_name}}</option>
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
          			{{ Form::text('users[email]', isset($participant->email) ? $participant->email : null, array('class'=>'input_control','id'=>'participantEmail','placeholder'=>'Email'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Phone *') }}
          			{{ Form::text('users[phone]', isset($participant->phone) ? $participant->phone : null, array('class'=>'input_control mobile-input-mask','placeholder'=>'Phone'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Date of Birth *','Date of Birth *') }}
          			{{ Form::text('userDetail[dob]', isset($participantDetail->dob) ? mdyDateFormate($participantDetail->dob) : null, array('class'=>'input_control dob-datepicker-element'))}}
          		</div>
      		</div>
      	</div>
  	</div>
  	<div class="full_width">
  		<div class="row">
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Address *') }}
          			{{ Form::text('users[address]', isset($participant->address) ? $participant->address : null, array('class'=>'input_control','placeholder'=>'Address'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('City *') }}
          			{{ Form::text('users[city]', isset($participant->city) ? $participant->city : null, array('class'=>'input_control','placeholder'=>'City'))}}
          		</div>
      		</div>
      		<div class="col-sm-3">
          		<div class="form-group">
      			{{ Form::label('State *') }}
      			{{ Form::select('users[state_id]', ['' => 'Please Select']+ $states->toArray(), isset($participant->state_id) ? $participant->state_id : null ,array('class' => 'element_select')) }}
          		</div>
      		</div>
  		</div>
  	</div>
  	<div class="full_width">
  		<div class="row">
      		<div class="col-sm-3">
          		<div class="form-group">
          			{{ Form::label('Zip *') }}
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
          			{{ Form::label('Gender *') }}
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
	<div class="full_width">
		<div class="row">
			<div class="col-sm-3">
				<div class="form-group">
					{{ Form::label('Race/Ethnicity') }}
					{{ Form::select('users[ethnicity]', ['' => 'Please Select','American Indian Or Alaska Native' => 'American Indian Or Alaska Native','Asian' => 'Asian','Black Or African American' => 'Black Or African American','Hispanic Or Latino' => 'Hispanic Or Latino','I Don\'t Wish To Answer' => 'I Don\'t Wish To Answer','Native Hawaiian Or Other Pecific Islander' => 'Native Hawaiian Or Other Pecific Islander','Two Or More Races' => 'Two Or More Races','White' => 'White'], isset($participant->ethnicity) ? $participant->ethnicity : null ,array('class' => 'element_select')) }}
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
                              <input type="checkbox" class="custom-control-input business_To p_view " name="inactive_user" value="1" @if($participant->is_active == 0) checked="" @endif>
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
