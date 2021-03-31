@extends('layouts.app-without-header')

@section('title','WMU |  Admin Profile')
@section('content')
<div class="Wrap_all_class padzero">
    <div class="Wrap_all_class_inner paddtopbtm">
        {{ Form::open(array('route'=>'admin.profile.update','id'=>'admin')) }}
        <input type="hidden" name="id" class="admin_id" value="{{ isset($id) ? $id : null }}">
    	<div class="add_edit_top_bar">
        	<div class="row">
        		<div class="col-sm-6">
        			<div class="add_edit_top_bar_left forupload_csuser" id="profPic">
        				<div class="user_prof_pic" id="cheoseFile">
        					<a href="javascript:void(0);">
	    						<div class="{{ (isset($admin->image)  && ($admin->image != "")) ? "" : "formid_cqw" }}">
		    						@if(isset($admin->image) && ($admin->image != "" )) 
		    						<img src="{{ $admin->image }}" id="output_image">
		    						@else
		    						<span><img src="{{ asset('images/icon-upload.svg') }}" id="output_image"></span>
		        					<p>Upload photo</p>
		    						@endif
	    						</div>
	        				</a>
        				</div>
        				<input type="file" name="user_image" class="profilePic" accept="image/*">
        				<div class="for_right_name">
        					@if(isset($id))
        						<h5>Admin</h5>
	        					<h2>{{isset($admin->full_name) ? $admin->full_name : null}}</h2>
	        					<p>Last login: {{isset($admin->last_login) ? lastLoginDisplay($admin->last_login) : null}}</p>
	        				@endif
        				</div>
        			</div>
        		</div>
        		<div class="col-sm-6">
        			<div class="right_bar_top_profile">
        				<h4><a href="{{ route('dashboard') }}" id="closed"><img src="{{ asset('images/icon-close.svg') }}"></a></h4>
        				<h4>
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
					<!-- <a class="nav-item nav-link" id="nav-labels-tab" data-toggle="tab" href="#nav-labels" role="tab" aria-controls="nav-labels" aria-selected="false">Labels</a> -->
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                	@include('dashboard.partials._admin-profile-section')                 
                </div>
				<!-- <div class="tab-pane fade" id="nav-labels" role="tabpanel" aria-labelledby="nav-labels-tab">
                    @include('dashboard.partials._admin-labels-section')
                </div> -->
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
@endsection
@section('extra')
    <script src="{{ asset('js/pages/dashboard/admin/profile.js') }}" type="text/javascript"></script>
@endsection