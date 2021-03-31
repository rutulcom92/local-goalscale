@extends('layouts.app-without-header')

@section('title','WMU |  Participant Profile')

@section('content')
<div class="Wrap_all_class padzero">
    <div class="Wrap_all_class_inner paddtopbtm">
    	{{ Form::open(array('route'=>'participant.profile.update','id'=>'participant')) }}
    	<input type="hidden" class="participant_id" name="id" value="{{ isset($id) ? $id : null }}">
        <div class="add_edit_top_bar">
        	<div class="row">
        		<div class="col-sm-6">
        			<div class="add_edit_top_bar_left {{ isset($participant->image) && ($participant->image != NULL) ? '' : 'forupload_csuser' }}" id="profPic">
        				<div class="user_prof_pic" id="chooseFile">
        					<a href="javascript:void(0);">
        						<div class="formid_cqw">
        						@if(isset($participant->image) && ($participant->image != NULL )) 
        						<img src="{{ $participant->image }}" id="participant_image">
        						@else
        						<span><img src="{{ asset('images/icon-upload.svg') }}" id="participant_image"></span>
	        						<p>Upload photo</p>
        						@endif
        						</div>
        					</a>
        				</div>
        				<input type="file" name="user_image" class="profilePic"  accept="image/*">
        				<div class="for_right_name">
        				@if(isset($id))
        					<h5>Participant</h5>
        					<h2>{{isset($participant->full_name) ? $participant->full_name : null}}</h2>
        					<p>Last login: {{isset($participant->last_login) ? lastLoginDisplay($participant->last_login) : null}}</p>
        				@endif	
        				</div>
        			</div>
        		</div>
        		<div class="col-sm-6">
        			<div class="right_bar_top_profile">
        				<h4> <a href="{{ route('dashboard') }}" id="closed"><img src="{{ asset('images/icon-close.svg') }}"></a></h4>
        				<h4> <input type="submit" class="btn-cls mrg-top" value="Save Changes"></h4>
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
                  	@include('participant.partials._user-profile-section')            
                </div>
            </div>
        </div> 
        {{ Form::close() }}
    </div>
</div>
@endsection

@section('extra')
<script src="{{ asset('js/pages/participant/profile.js') }}" type="text/javascript"></script>
@endsection