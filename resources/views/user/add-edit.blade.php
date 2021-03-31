@extends('layouts.app-without-header')

@section('title','WMU | Add New User')

@section('content')
<div class="Wrap_all_class padzero">
    <div class="Wrap_all_class_inner paddtopbtm">
        <div class="add_edit_top_bar">
        	<div class="row">
        		<div class="col-sm-6">
        			<div class="add_edit_top_bar_left forupload_csuser">
        				<div class="user_prof_pic">
        					<a href="javascript:void(0);">
        						<div class="formid_cqw">
	        						<span><img src="{{ asset('images/icon-upload.svg') }}"></span>
	        						<p>Upload photo</p>
        						</div>
        					</a>
        				</div>
        				<div class="for_right_name">
        					<h2>New User</h2>
        					<p>Last login: 9/20/2019 @ 2:30pm</p>
        				</div>
        			</div>
        		</div>
        		<div class="col-sm-6">
        			<div class="right_bar_top_profile">
        				<h4><a href="<?php echo url('/');?>/provider"><img src="{{ asset('images/icon-close.svg') }}"></a></h4>
        				<h4><a href="javascript:void(0);" class="btn-cls mrg-top">Save Changes</a></h4>
        			</div>
        		</div>
        	</div>
        </div>

        <div class="full_width Tabs_cls_cool marg40">
            <nav>
                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                  <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true">Profile</a>
                  <a class="nav-item nav-link" id="nav-activity-tab" data-toggle="tab" href="#nav-activity" role="tab" aria-controls="nav-activity" aria-selected="true">Activity</a>
                  <a class="nav-item nav-link" id="nav-goals-tab" data-toggle="tab" href="#nav-goals" role="tab" aria-controls="nav-goals" aria-selected="false">Goals</a>
                  <a class="nav-item nav-link" id="nav-users-tab" data-toggle="tab" href="#nav-users" role="tab" aria-controls="nav-users" aria-selected="false">Users</a>
                  <a class="nav-item nav-link" id="nav-notes-tab" data-toggle="tab" href="#nav-notes" role="tab" aria-controls="nav-notes" aria-selected="false">Notes</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                  	<div class="form_field_cls">
	                  	<div class="full_width">
		                  	<div class="row">
		                  		<div class="col-sm-3">
			                  		<div class="form-group">
			                  			<label>First Name</label>
			                  			<input type="text" class="input_control" value="Warren" placeholder="First name">
			                  		</div>
		                  		</div>
		                  		<div class="col-sm-3">
			                  		<div class="form-group">
			                  			<label>Last Name</label>
			                  			<input type="text" class="input_control" value="Mills" placeholder="Last name">
			                  		</div>
		                  		</div>
		                  		<div class="col-sm-3">
			                  		<div class="form-group">
			                  			<label>Role</label>
			                  			<select class="element_select">
			                  				<option>Provider</option>
			                  				<option>Role 1</option>
			                  			</select>
			                  		</div>
		                  		</div>
		                  	</div>
	                  	</div>
	                  	<div class="full_width">
		                  	<div class="row">
		                  		<div class="col-sm-3">
			                  		<div class="form-group">
			                  			<label>Email</label>
			                  			<input type="text" class="input_control" placeholder="Email" value="helen.barton@gmail.com">
			                  		</div>
		                  		</div>
		                  		<div class="col-sm-3">
			                  		<div class="form-group">
			                  			<label>Phone</label>
			                  			<input type="text" class="input_control" value="321-456-7890">
			                  		</div>
		                  		</div>
		                  		<div class="col-sm-3">
			                  		<div class="form-group">
			                  			<label>Date of Birth</label>
			                  			<input type="date" class="input_control" value="11/19/1985">
			                  		</div>
		                  		</div>
		                  	</div>
	                  	</div>
	                  	<div class="full_width">
	                  		<div class="row">
		                  		<div class="col-sm-3">
			                  		<div class="form-group">
			                  			<label>Address</label>
			                  			<input type="text" class="input_control" value="600 E Michigan Ave">
			                  		</div>
		                  		</div>
		                  		<div class="col-sm-3">
			                  		<div class="form-group">
			                  			<label>City</label>
			                  			<input type="text" class="input_control" value="Kalamazoo">
			                  		</div>
		                  		</div>
		                  		<div class="col-sm-3">
			                  		<div class="form-group">
		                  			<label>State</label>
		                  			<select class="element_select">
		                  				<option>MI</option>
		                  				<option>MI 1</option>
		                  			</select>
			                  		</div>
		                  		</div>
	                  		</div>
	                  	</div>
	                  	<div class="full_width">
	                  		<div class="row">
		                  		<div class="col-sm-3">
			                  		<div class="form-group">
			                  			<label>Zip</label>
			                  			<input type="text" class="input_control" value="40997">
			                  		</div>
		                  		</div>
		                  		<div class="col-sm-3">
			                  		<div class="form-group">
			                  			<label>Record #</label>
			                  			<input type="text" class="input_control" value="123456">
			                  		</div>
		                  		</div>
		                  		<div class="col-sm-3">
			                  		<div class="form-group">
			                  			<label>Gender</label>
			                  			<div class="full_width">
				                  			<div class="half_radio_cl">
		                                      <div class="custom_radio">
		                                        <input type="radio" id="test6" value="1" name="radio-group" checked="">
		                                        <label for="test6">Male</label>
		                                      </div>
	                                    	</div>
	                                    	<div class="half_radio_cl">
		                                      <div class="custom_radio">
		                                        <input type="radio" id="test7" value="1" name="radio-group" >
		                                        <label for="test7">Female</label>
		                                      </div>
	                                    	</div>
	                                    	<div class="half_radio_cl">
		                                      <div class="custom_radio">
		                                        <input type="radio" id="test8" value="1" name="radio-group">
		                                        <label for="test8">Other</label>
		                                      </div>
	                                    	</div>
                                    	</div>
			                  		</div>
		                  		</div>
	                  		</div>
	                  	</div>
	                  	<div class="full_width separator_div"></div>
	                  	<div class="full_width forgot_pass">
	                  		<div class="row">
	                  			<div class="col-sm-3">
			                  		<h6>Set Password</h6>
			                  		<div class="full_width">
			                  			<a href="javascript:void(0);" class="btn-cls h31">Generate Password</a>
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
			                                    <input type="checkbox" class="custom-control-input business_To p_view " name="permission[jobs][view]" value="1" checked="">
			                                    <span class="custom-control-indicator"></span>
			                                    <div class="custom-control-description">Send the new user an email about their account and a password reset link</div>
			                                </label>
			                            </div>
		                            </div>
		                  		</div>
		                  	</div>
	                  	</div>
                  	</div>                  
                </div>
                <div class="tab-pane fade" id="nav-activity" role="tabpanel" aria-labelledby="nav-activity-tab">
                    <div class="form_field_cls">
                    	<h2>Activity</h2>
                    </div>                
                </div>
                <div class="tab-pane fade" id="nav-goals" role="tabpanel" aria-labelledby="nav-goals-tab">
                	<div class="form_field_cls">
                    	<h2>Goals</h2>
                    </div> 
                </div>
                <div class="tab-pane fade" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab">
                    <div class="form_field_cls">
                    	<h2>Users</h2>
                    </div>
                </div> 
            </div>
        </div> 
    </div>
</div>
@endsection