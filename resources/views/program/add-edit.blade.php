@extends('layouts.app-without-header')

@section('title','WMU | Add New Program')

@section('content')
 <div class="Wrap_all_class_inner paddtopbtm">
    @if(isset($id))
        {{ Form::open(array('route' => array('program.update', $id), 'id' => 'programForm')) }}
        @method('PUT')
    @else
        {{ Form::open(array('route'=>'program.store','id'=>'programForm')) }}
    @endif
    <input type="hidden" name="id" value="{{isset($id) ? $id : null}}" id="program_id">
        <div class="add_edit_top_bar">
        	<div class="row">
                <div class="col-sm-6">
                   <div class="add_edit_top_bar_left forupload_csuser" id="profPic">
                       <div class="user_prof_pic" id="chooseFile">
                            <a href="javascript:void(0);">
                                <div class="{{ (isset($program->image)  && ($program->image != "")) ? "" : "formid_cqw" }}">
                                    @if(isset($program->image) && ($program->image != "" )) 
                                    <img src="{{ $program->image }}" id="programImage">
                                    @else
                                    <span><img src="{{ asset('images/icon-upload.svg') }}" id="programImage"></span>
                                    <p>Upload photo</p>
                                    @endif
                                </div>
                            </a>
                        </div>
                        <input type="file" name="program_image" class="profilePic">
                        <div class="for_right_name">
                        @if(isset($id))
                            <h5>{{ isset($organization->program_label) ? $organization->program_label : 'Program' }}</h5>
                            <h2>{{isset($program->name) ? $program->name : null}}</h2>
                        @endif  
                        </div>
                    </div>
                </div>
        		<div class="col-sm-6">
        			<div class="right_bar_top_profile">
        				<!-- <h4><a id="closed" href="javascript:void(0)"><img src="{{ asset('images/icon-close.svg') }}"></a></h4> -->
                       
                          @if(!isset($org_id))
                             <h4><a href="javascript:void(0);" id="closed1"><img src="{{ asset('images/icon-close.svg') }}"></a></h4>
                            <input type="hidden" id="back_url" name="url" value="{{ route('program.index') }}">
                        @else
                           <input type="hidden" id="back_url" name="url" value="{{ route('organization.edit', array($org_id)) }}">
                            <h4><a href="javascript:void(0);" id="closed"><img src="{{ asset('images/icon-close.svg') }}"></a></h4>
                        @endif
        					<input type="submit" class="btn-cls mrg-top float-right" value="Save Changes">
        				</h4>
        			</div>
        		</div>
        	</div>
        </div>

        <div class="full_width Tabs_cls_cool marg40">
            <nav>
                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-details-tab" data-toggle="tab" href="#nav-details" role="tab" aria-controls="nav-details" aria-selected="true">Details</a>
                    @if(isset($id))                                        
                        <a class="nav-item nav-link" id="nav-supervisors-tab" data-toggle="tab" href="#nav-supervisors" role="tab" aria-controls="nav-supervisors" aria-selected="false">{{ isset($organization->supervisor_label) ? $organization->supervisor_label.'s' : 'Supervisors' }}</a>
                        <a class="nav-item nav-link" id="nav-providers-tab" data-toggle="tab" href="#nav-providers" role="tab" aria-controls="nav-providers" aria-selected="false">{{ isset($organization->provider_label) ? $organization->provider_label.'s' : 'Providers' }}</a>
                        <a class="nav-item nav-link" id="nav-users-tab" data-toggle="tab" href="#nav-users" role="tab" aria-controls="nav-users" aria-selected="false">{{ isset($organization->participant_label) ? $organization->participant_label.'s' : 'Participants' }}</a>
                        <a class="nav-item nav-link" id="nav-goals-tab" data-toggle="tab" href="#nav-goals" role="tab" aria-controls="nav-goals" aria-selected="false">
                        Goals</a>
                    @endif
                    <a class="nav-item nav-link" id="nav-notes-tab" data-toggle="tab" href="#nav-notes" role="tab" aria-controls="nav-notes" aria-selected="false">Notes</a>
                </div>
               <!--  <div class="for_ty_export"><a href="javascript:void(0);"><img src="{{ asset('images/export.png') }}"> <span>Export program’s Data</span></a></div> -->
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-details" role="tabpanel" aria-labelledby="nav-details-tab">
                    @include('program.partials._add-edit-details-section')
                </div>
                @if(isset($id))      
                    <div class="tab-pane fade" id="nav-supervisors" role="tabpanel" aria-labelledby="nav-supervisors-tab">
                        @include('program.partials._add-edit-supervisors-section')
                    </div>
                    <div class="tab-pane fade" id="nav-providers" role="tabpanel" aria-labelledby="nav-providers-tab">
                        @include('program.partials._add-edit-providers-section') 
                    </div>
                    <div class="tab-pane fade" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab">
                        @include('program.partials._add-edit-users-section')                    
                    </div>
                     <div class="tab-pane fade" id="nav-goals" role="tabpanel" aria-labelledby="nav-goals-tab">
                        @include('program.partials._add-edit-goals-section')                    
                    </div>
                @endif
                <div class="tab-pane fade" id="nav-notes" role="tabpanel" aria-labelledby="nav-notes-tab">
                    @include('program.partials._add-edit-notes-section')
                </div>
            </div>
        </div>
    {{ Form::close() }}    
</div>
@endsection
@section('extra')
<script src="{{ asset('js/pages/program/add_edit.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/program/supervisor/index.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/program/provider/index.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/program/user/index.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/program/goal/index.js') }}" type="text/javascript"></script>
@endsection