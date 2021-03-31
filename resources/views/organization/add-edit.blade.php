@extends('layouts.app-without-header')

@section('title','WMU | Add New Organization')

@section('content')
 <div class="Wrap_all_class_inner paddtopbtm">
    @if(isset($id))
        {{ Form::open(array('route' => array('organization.update', $id), 'id' => 'organizationForm')) }}
        @method('PUT')
    @else
        {{ Form::open(array('route'=>'organization.store','id'=>'organizationForm')) }}
    @endif
    <input type="hidden" name="id" value="{{isset($id) ? $id : null}}" id="organization_id">
        <div class="add_edit_top_bar">
        	<div class="row">
                <div class="col-sm-6">
                    <div class="add_edit_top_bar_left {{ isset($organization->logo_image) && ($organization->logo_image != NULL) ? '' : 'forupload_csuser' }}" id="profPic">
                        <div class="user_prof_pic" id="chooseFile">
                            <a href="javascript:void(0);">
                                <div class="formid_cqw">
                                @if(isset($organization->logo_image) && ($organization->logo_image != NULL )) 
                                <img src="{{ $organization->logo_image }}" id="organization_image">
                                @else
                                <span><img src="{{ asset('images/icon-upload.svg') }}" id="organization_image"></span>
                                    <p>Upload photo</p>
                                @endif
                                </div>
                            </a>
                        </div>
                        <input type="file" name="organization_logo" id="organization-logo" style="display: none;">
                        <!-- <input type="file" name="organization_image" class="profilePic"> -->
                        <div class="for_right_name">
                        @if(isset($id))
                            <h5>Organization</h5>
                            <h2>{{isset($organization->name) ? $organization->name : null}}</h2>
                        @endif  
                        </div>
                    </div>
                </div>
        		<div class="col-sm-6">
        			<div class="right_bar_top_profile">
                         <h4><a href="javascript:void(0);" id="closed1"><img src="{{ asset('images/icon-close.svg') }}"></a></h4>
                        <input type="hidden" id="back_url" name="url" value="{{ route('organization.index') }}">  
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
                    
                        <a class="nav-item nav-link" id="nav-programs-tab" data-toggle="tab" href="#nav-programs" role="tab" aria-controls="nav-programs" aria-selected="false">
                            {{ isset($organization->program_label) ? $organization->program_label.'s' : 'Programs' }}
                        </a>
                        
                        <a class="nav-item nav-link" id="nav-admin-tab" data-toggle="tab" href="#nav-admins" role="tab" aria-controls="nav-admins" aria-selected="false">
                            Administrators
                        </a>
                        
                        <a class="nav-item nav-link" id="nav-supervisors-tab" data-toggle="tab" href="#nav-supervisors" role="tab" aria-controls="nav-supervisors" aria-selected="false">
                            {{ isset($organization->supervisor_label) ? $organization->supervisor_label.'s' : 'Supervisors' }}    
                        </a>
                        
                        <a class="nav-item nav-link" id="nav-providers-tab" data-toggle="tab" href="#nav-providers" role="tab" aria-controls="nav-providers" aria-selected="false">
                            {{ isset($organization->provider_label) ? $organization->provider_label.'s' : 'Providers' }}
                        </a>
                        <a class="nav-item nav-link" id="nav-participants-tab" data-toggle="tab" href="#nav-participants" role="tab" aria-controls="nav-participants" aria-selected="false">
                            {{ isset($organization->participant_label) ? $organization->participant_label.'s' : 'Participants' }}
                        </a>

                        <a class="nav-item nav-link" id="nav-goals-tab" data-toggle="tab" href="#nav-goals" role="tab" aria-controls="nav-goals" aria-selected="false">Goals</a>

                        <a class="nav-item nav-link" id="nav-notes-tab" data-toggle="tab" href="#nav-notes" role="tab" aria-controls="nav-notes" aria-selected="false">Notes</a>

                        <a class="nav-item nav-link" id="nav-labels-tab" data-toggle="tab" href="#nav-labels" role="tab" aria-controls="nav-labels" aria-selected="false">Labels</a>

                        <!--  <a class="nav-item nav-link" id="nav-settings-tab" data-toggle="tab" href="#nav-settings" role="tab" aria-controls="nav-settings" aria-selected="false">Settings</a> -->
                    @endif
                </div>
               <!--  <div class="for_ty_export"><a href="javascript:void(0);"><img src="{{ asset('images/export.png') }}"> <span>Export Organization’s Data</span></a></div> -->
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-details" role="tabpanel" aria-labelledby="nav-details-tab">
                    @include('organization.partials._add-edit-details-section')
                </div>
                @if(isset($id))
                <div class="tab-pane fade" id="nav-admins" role="tabpanel" aria-labelledby="nav-admins-tab">
                    @include('organization.partials._list-admin-section')
                </div>
                <div class="tab-pane fade" id="nav-programs" role="tabpanel" aria-labelledby="nav-programs-tab">
                    @include('organization.partials._add-edit-programs-section')
                </div>
                <div class="tab-pane fade" id="nav-supervisors" role="tabpanel" aria-labelledby="nav-supervisors-tab">
                    @include('organization.partials._add-edit-supervisors-section')
                </div>
                <div class="tab-pane fade" id="nav-providers" role="tabpanel" aria-labelledby="nav-providers-tab">
                    @include('organization.partials._add-edit-providers-section') 
                </div>
                <div class="tab-pane fade" id="nav-participants" role="tabpanel" aria-labelledby="nav-participants-tab">
                    @include('organization.partials._add-edit-participants-section')                    
                </div>
                <div class="tab-pane fade" id="nav-goals" role="tabpanel" aria-labelledby="nav-goals-tab">
                    @include('organization.partials._add-edit-goals-section')
                </div>
                <div class="tab-pane fade" id="nav-notes" role="tabpanel" aria-labelledby="nav-notes-tab">
                    @include('organization.partials._add-edit-notes-section')
                </div>
                <div class="tab-pane fade" id="nav-labels" role="tabpanel" aria-labelledby="nav-labels-tab">
                    @include('organization.partials._add-edit-labels-section')
                </div>
               <!--  <div class="tab-pane fade" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">
                    @include('organization.partials._add-edit-settings-section')
                </div> -->
                @endif
            </div>
        </div>
    {{ Form::close() }}    
</div>
@endsection
@section('extra')
<script src="{{ asset('js/pages/organization/program/index.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/organization/add_edit.js') }}" type="text/javascript"></script>
@if(isset($id))
<script src="{{ asset('js/pages/organization/supervisor/index.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/organization/provider/index.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/organization/participant/index.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/organization/administrator/index.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/organization/goal/index.js') }}" type="text/javascript"></script>
@endif
@endsection