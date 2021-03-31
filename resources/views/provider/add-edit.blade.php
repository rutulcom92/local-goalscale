@extends('layouts.app-without-header')

@if(isset($id))
    @section('title','WMU |  Edit Provider')
@else
    @section('title','WMU |  Add New Provider')
@endif

@section('content')
<div class="Wrap_all_class padzero">
    <div class="Wrap_all_class_inner paddtopbtm">
    	@if(isset($id))
    	{{ Form::open(array('route' => array('provider.update', $id), 'id' => 'provider')) }}
        @method('PUT')
    	@else
    	{{ Form::open(array('route'=>'provider.store','id'=>'provider')) }}
    	@endif
    	<div class="provider_id" style="display: none;">{{ isset($id) ? $id : null }}</div>
        <div class="add_edit_top_bar">
        	<div class="row">
        		<div class="col-sm-6">
        			<div class="add_edit_top_bar_left forupload_csuser" id="profPic">
        				<div class="user_prof_pic" id="chooseFile">
	        				<a href="javascript:void(0);">
	    						<div class="{{ (isset($provider->image)  && ($provider->image != "")) ? "" : "formid_cqw" }}">
		    						@if(isset($provider->image) && ($provider->image != "" )) 
		    						<img src="{{ $provider->image }}" id="provider_image">
		    						@else
		    						<span><img src="{{ asset('images/icon-upload.svg') }}" id="provider_image"></span>
		        						<p>Upload photo</p>
		    						@endif
	    						</div>
	        				</a>
        				</div>
        				<input type="file" name="user_image" class="profilePic">
        				<div class="for_right_name">
        				@if(isset($id))
        					<h5>{{ isset($organization->provider_label) ? $organization->provider_label : 'Provider' }}</h5>
        					<h2>{{isset($provider->full_name) ? $provider->full_name : null}}</h2>
        					<p>Last login: {{isset($provider->last_login) ? lastLoginDisplay($provider->last_login) : null}}
        				@endif	
        				</div>
        			</div>
        		</div>
        		<div class="col-sm-6">
        			<div class="right_bar_top_profile">
        				 @if(!isset($org_id))
                             <h4><a href="javascript:history.go(-1);" id="closed1"><img src="{{ asset('images/icon-close.svg') }}"></a></h4>
                            <input type="hidden" id="back_url" name="url" value="{{ route('provider.index') }}">
                        @else
                            <input type="hidden" id="back_url" name="url" value="{{ route('organization.edit', array($org_id)) }}">
                            <h4><a href="javascript:history.go(-1);" id="closed"><img src="{{ asset('images/icon-close.svg') }}"></a></h4>
                        @endif
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
                     @if(isset($id))
                    <a class="nav-item nav-link" id="nav-goals-tab" data-toggle="tab" href="#nav-goals" role="tab" aria-controls="nav-goals" aria-selected="false">Goals</a>
                    <a class="nav-item nav-link" id="nav-users-tab" data-toggle="tab" href="#nav-users" role="tab" aria-controls="nav-users" aria-selected="false">{{ isset($organization->participant_label) ? $organization->participant_label.'s' : 'Participants' }}</a>
                    @endif
                    <a class="nav-item nav-link" id="nav-notes-tab" data-toggle="tab" href="#nav-notes" role="tab" aria-controls="nav-notes" aria-selected="false">Notes</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                  	@include('provider.partials._add-edit-profile-section')                  
                </div>
                <div class="tab-pane fade" id="nav-goals" role="tabpanel" aria-labelledby="nav-goals-tab">
                     @include('provider.partials._add-edit-goal-section')           
                </div>
                <div class="tab-pane fade" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab">
                	@include('provider.partials._add-edit-participant-section')
                </div>
                <div class="tab-pane fade" id="nav-notes" role="tabpanel" aria-labelledby="nav-notes-tab">
                    <div class="notes_Uimain">
                    	<div class="form-group">
                    		<label>Add notes about this provider (these are private, only viewable by supervisors)</label>
                    		{{ Form::textarea('users[notes]',isset($provider->notes) ? $provider->notes : null,array('class'=> 'clsheightarea','placeholder'=>'Provider Notes')) }}
                    	</div>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
@endsection

@section('extra')
<script src="{{ asset('js/pages/provider/add_edit.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/provider/participant/index.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/provider/goal/index.js') }}" type="text/javascript"></script>
@endsection