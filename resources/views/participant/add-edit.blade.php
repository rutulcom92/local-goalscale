 @extends('layouts.app-without-header')

@if(isset($id))
    @section('title','WMU |  Edit Participant')
@else
    @section('title','WMU |  Add New Participant')
@endif

@section('content')
<div class="Wrap_all_class padzero">
    <div class="Wrap_all_class_inner paddtopbtm">
    	@if(isset($id))
    	{{ Form::open(array('route' => array('participant.update', $id), 'id' => 'participant')) }}
        @method('PUT')
    	@else
    	{{ Form::open(array('route'=>'participant.store','id'=>'participant')) }}
    	@endif
    	<div class="participant_id" style="display: none;">{{ isset($id) ? $id : null }}</div>
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
        				<input type="file" name="user_image" class="profilePic">
        				<div class="for_right_name">
        				@if(isset($id))
        					<h5>{{ isset($organization->participant_label) ? $organization->participant_label : 'Participant' }}</h5>
        					<h2>{{isset($participant->full_name) ? $participant->full_name : null}}</h2>
        					<p>Last login: {{isset($participant->last_login) ? lastLoginDisplay($participant->last_login) : null}}</p>
        				@endif	
        				</div>
        			</div>
        		</div>
        		<div class="col-sm-6">
        			<div class="right_bar_top_profile">
        				  @if(!isset($org_id))
                             <h4><a href="javascript:history.go(-1);" id="closed1"><img src="{{ asset('images/icon-close.svg') }}"></a></h4>
                            <input type="hidden" id="back_url" name="url" value="{{ route('participant.index') }}">
                        @else
                            <input type="hidden" id="back_url" name="url" value="{{ route('organization.edit', array($org_id)) }}">
                            <h4><a href="javascript:history.go(-1);" id="closed"><img src="{{ asset('images/icon-close.svg') }}"></a></h4>
                        @endif
        				<h4> <input type="submit" class="btn-cls mrg-top" value="Save Changes"></h4>
        			</div>
        		</div>
        	</div>
        </div>

        <div class="full_width Tabs_cls_cool part_sec marg40">
            <nav>
                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                  <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true">Profile</a>
                  @if(isset($id))
                  <a class="nav-item nav-link" id="nav-goals-tab" data-toggle="tab" href="#nav-goals" role="tab" aria-controls="nav-goals" aria-selected="false">Goals</a>
                  @endif
                  <a class="nav-item nav-link" id="nav-notes-tab" data-toggle="tab" href="#nav-notes" role="tab" aria-controls="nav-notes" aria-selected="false">Notes</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                  	@include('participant.partials._add-edit-profile-section')            
                </div>
                <div class="tab-pane fade" id="nav-goals" role="tabpanel" aria-labelledby="nav-goals-tab">
                    @include('participant.partials._add-edit-goal-section')    
                </div>
                <div class="tab-pane fade" id="nav-notes" role="tabpanel" aria-labelledby="nav-notes-tab">
                    <div class="notes_Uimain">
                    	<div class="form-group">
                    		<label>Add notes about this participant (these are private, only viewable by supervisors and providers)</label>
                    		{{ Form::textarea('users[notes]',isset($participant->notes) ? $participant->notes : null,array('class'=> 'clsheightarea' , 'id' => 'notes','placeholder'=>'Participant Notes')) }}
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
<script src="{{ asset('js/pages/participant/add_edit.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/participant/goal/index.js') }}" type="text/javascript"></script>
@endsection