@extends('layouts.app-without-header')

@if(isset($id))
  @section('title','WMU |  Edit Admin')
@else
  @section('title','WMU |  Add New Admin')
@endif

@section('content')
<div class="Wrap_all_class padzero">
    <div class="Wrap_all_class_inner paddtopbtm">
      @if(isset($id))
      {{ Form::open(array('route' => array('admin.update', $id), 'id' => 'admin')) }}
        @method('PUT')
      @else
      {{ Form::open(array('route'=>'admin.store','id'=>'admin')) }}
      @endif
      <input type="hidden" id="admin_id" value="{{ isset($id) ? $id : null }}">
        <div class="add_edit_top_bar">
          <div class="row">
            <div class="col-sm-6">
              <div class="add_edit_top_bar_left forupload_csuser" id="profPic">
                <div class="user_prof_pic" id="cheoseFile">
                  <a href="javascript:void(0);">
                  <div class="{{ (isset($orgAdmin->image)  && ($orgAdmin->image != "")) ? "" : "formid_cqw" }}">
                    @if(isset($orgAdmin->image) && ($orgAdmin->image != "" )) 
                    <img src="{{ $orgAdmin->image }}" id="output_image">
                    @else
                    <span><img src="{{ asset('images/icon-upload.svg') }}" id="output_image"></span>
                      <p>Upload photo</p>
                    @endif
                  </div>
                  </a>
                </div>
                <input type="file" name="user_image" class="profilePic">
                <div class="for_right_name">
                  @if(isset($id))
                    <h5>Admin</h5>
                    <h2>{{isset($orgAdmin->full_name) ? $orgAdmin->full_name : null}}</h2>
                    <p>Last login: {{isset($orgAdmin->last_login) ? lastLoginDisplay($orgAdmin->last_login) : null}}</p>
                  @endif
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="right_bar_top_profile">
                <h4><a href="javascript:void(0);" id="closed"><img src="{{ asset('images/icon-close.svg') }}"></a>
                <input type="hidden" id="backUrl" name="url" value="{{ route('organization.index') }}"></h4>
                <h4><!-- <a href="javascript:void(0);" class="btn-cls mrg-top">Save Changes</a> -->
                  <input type="submit" class="btn-cls mrg-top" value="Save Changes">
                </h4>
              </div>
            </div>
          </div>
        </div>

        <div class="full_width Tabs_cls_cool marg40">
            <nav>
                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true">Profile</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                  <div class="form_field_cls">
      <div class="full_width">
        <div class="row">
          <div class="col-sm-3">
              <div class="form-group">
                {{ Form::label('First Name *') }}
                {{ Form::text('users[first_name]', isset($orgAdmin->first_name) ? $orgAdmin->first_name : null, array('class'=>'input_control','placeholder'=>'First name'))}}
              </div>
          </div>
          <div class="col-sm-3">
              <div class="form-group">
                {{ Form::label('Last Name *') }}
                {{ Form::text('users[last_name]', isset($orgAdmin->last_name) ? $orgAdmin->last_name : null, array('class'=>'input_control','placeholder'=>'Last name'))}}
              </div>
          </div>
        </div>
        </div>
        <div class="full_width">
          <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                  {{ Form::label('Organization *') }}
                  {{ Form::select('users[organization_id]', $organizations->toArray(), isset($orgAdmin->organization_id) ? $orgAdmin->organization_id : null ,array('class' => 'element_select')) }}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                  {{ Form::label('Program *') }}
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
          </div>
        </div>
        <div class="full_width">
          <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                  {{ Form::label('Email *') }}
                  {{ Form::text('users[email]', isset($orgAdmin->email) ? $orgAdmin->email : null, array('class'=>'input_control','id'=>'adminEmail', 'placeholder'=>'Email'))}}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                  {{ Form::label('Phone *') }}
                  {{ Form::text('users[phone]', isset($orgAdmin->phone) ? $orgAdmin->phone : null, array('class'=>'input_control mobile-input-mask','placeholder'=>'Phone'))}}
                </div>
            </div>
          </div>
        </div>
        <div class="full_width">
          <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                  {{ Form::label('Address *') }}
                  {{ Form::text('users[address]', isset($orgAdmin->address) ? $orgAdmin->address : null, array('class'=>'input_control','placeholder'=>'Address'))}}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                  {{ Form::label('City *') }}
                  {{ Form::text('users[city]', isset($orgAdmin->city) ? $orgAdmin->city : null, array('class'=>'input_control','placeholder'=>'City'))}}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
              {{ Form::label('State *') }}
              {{ Form::select('users[state_id]', ['' => 'Please Select']+ $states->toArray(), isset($orgAdmin->state_id) ? $orgAdmin->state_id : null ,array('class' => 'element_select')) }}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                  {{ Form::label('Zip *') }}
                  {{ Form::text('users[zip]', isset($orgAdmin->zip) ? $orgAdmin->zip : null, array('class'=>'input_control zip-input-mask','placeholder'=>'Zip'))}}
                </div>
            </div>
          </div>
        </div>
        <div class="full_width">
          <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                  {{ Form::label('Record # (enter N/A if not applicable)*') }}
                  {{ Form::text('users[record_num]', isset($orgAdmin->record_num) ? $orgAdmin->record_num : 0, array('class'=>'input_control','placeholder'=>'Record'))}}
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
        </div>
       </div>
      </div>
      {{ Form::close() }}
    </div>
</div>
@endsection

@section('extra')
<script src="{{ asset('js/pages/organization/administrator/add_edit.js') }}" type="text/javascript"></script>
@endsection