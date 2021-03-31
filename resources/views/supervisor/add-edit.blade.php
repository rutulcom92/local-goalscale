@extends('layouts.app-without-header')

@if(isset($id))
	@section('title','WMU |  Edit Supervisor')
@else
	@section('title','WMU |  Add New Supervisor')
@endif

@section('content')
<div class="Wrap_all_class padzero">
    <div class="Wrap_all_class_inner paddtopbtm">
    	@if(isset($id))
    	{{ Form::open(array('route' => array('supervisor.update', $id), 'id' => 'supervisor')) }}
        @method('PUT')
    	@else
    	{{ Form::open(array('route'=>'supervisor.store','id'=>'supervisor')) }}
    	@endif
    	<div class="supervisor_id" style="display: none;">{{ isset($id) ? $id : null }}</div>
        <div class="add_edit_top_bar">
        	<div class="row">
        		<div class="col-sm-6">
        			<div class="add_edit_top_bar_left forupload_csuser" id="profPic">
        				<div class="user_prof_pic" id="cheoseFile">
        					<a href="javascript:void(0);">
	    						<div class="{{ (isset($supervisor->image)  && ($supervisor->image != "")) ? "" : "formid_cqw" }}">
		    						@if(isset($supervisor->image) && ($supervisor->image != "" )) 
		    						<img src="{{ $supervisor->image }}" id="output_image">
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
        						<h5>{{ isset($organization->supervisor_label) ? $organization->supervisor_label : 'Supervisor' }}</h5>
	        					<h2>{{isset($supervisor->full_name) ? $supervisor->full_name : null}}</h2>
	        					<p>Last login: {{isset($supervisor->last_login) ? lastLoginDisplay($supervisor->last_login) : null}}</p>
	        				@endif
        				</div>
        			</div>
        		</div>
        		<div class="col-sm-6">
        			<div class="right_bar_top_profile">

                        @if(!isset($org_id))
                             <h4><a href="javascript:history.go(-1);" id="closed1"><img src="{{ asset('images/icon-close.svg') }}"></a></h4>
                            <input type="hidden" id="back_url" name="url" value="{{ route('supervisor.index') }}">
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
	                    <a class="nav-item nav-link" id="nav-programs-tab" data-toggle="tab" href="#nav-programs" role="tab" aria-controls="nav-programs" aria-selected="true">
							{{ isset($organization->program_label) ? $organization->program_label.'s' : 'Programs' }}
						</a>

	                    <a class="nav-item nav-link" id="nav-providers-tab" data-toggle="tab" href="#nav-providers" role="tab" aria-controls="nav-providers" aria-selected="false">
							{{ isset($organization->provider_label) ? $organization->provider_label.'s' : 'Providers' }}
						</a>

                         <a class="nav-item nav-link" id="nav-goals-tab" data-toggle="tab" href="#nav-goals" role="tab" aria-controls="nav-goals" aria-selected="false">Goals</a>

                    @endif

                    <a class="nav-item nav-link" id="nav-notes-tab" data-toggle="tab" href="#nav-notes" role="tab" aria-controls="nav-notes" aria-selected="false">Notes</a>

                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                	@include('supervisor.partials._add-edit-profile-section')                 
                </div>
                @if(isset($id))
	                <div class="tab-pane fade" id="nav-programs" role="tabpanel" aria-labelledby="nav-programs-tab">
	                	@include('supervisor.partials._add-edit-program-section')
	                </div>
	                <div class="tab-pane fade" id="nav-providers" role="tabpanel" aria-labelledby="nav-providers-tab">
	                	@include('supervisor.partials._add-edit-provider-section')                 
	                </div>
	            @endif
                <div class="tab-pane fade" id="nav-goals" role="tabpanel" aria-labelledby="nav-goals-tab">
                	@include('supervisor.partials._add-edit-goal-section')
                </div>
                <div class="tab-pane fade" id="nav-notes" role="tabpanel" aria-labelledby="nav-notes-tab">
                    <div class="notes_Uimain">
                    	<div class="form-group">
                    		<label>Add notes about this supervisor (these are private, only viewable by an admin)</label>
                    		{{ Form::textarea('users[notes]', isset($supervisor->notes) ? $supervisor->notes : null, array('class'=>'clsheightarea','placeholder'=>'Supervisor Notes'))}}
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
<script src="{{ asset('js/pages/supervisor/add_edit.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/supervisor/provider/index.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/supervisor/program/index.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/supervisor/goal/index.js') }}" type="text/javascript"></script>
@endsection