@extends('layouts.app-without-header')

@section('title','WMU | Edit Goal')

@section('content')
<div class="Wrap_all_class padzero">
    <div class="Wrap_all_class_inner paddtopbtm">
        <div class="for_goal_top_panle_cls">
        	<div class="row align-items-center">
        		<div class="col-sm-8">
        			<div class="for_title_goal_UIclsd">
        				<h2>{{$goal_detail->name}}</h2>
        				<div class="for_tags_cls_goal">
        					<label>Tags:</label>
        					@include('goal.edit._goal-tags')
        				</div>
        			</div>
        		</div>
        		<div class="col-sm-4">
        			<div class="right_bar_top_profile for_ctc_goal_UI">
        				<ul>
                            @if($goal_detail->status_id != goalCloseStatusId() && (Auth::user()->user_type_id == superAdminUserTypeId() || Auth::user()->user_type_id == providerUserTypeId()))
        					   <li><a href="" class="sm_nwUIbtn close_goal" data-get-goal-close-url = "{{route('goal.change-status-close',$goal_detail->id)}}">Discontinue Goal</a></li>
                            @endif
                            @if(Auth::user()->user_type_id == superAdminUserTypeId())
                             {{ Form::open(array('route' => array('goal.details.export', $goal_detail->id), 'id' => 'goalExportForm', 'files' => 'true')) }}
                                <input type="hidden" id="goalGraph" name="goalgrp">
                                <li><buttton type="button" id="export-to-pdf" class="sm_nwUIbtn">Export to PDF</button></li>
                           {{ Form::close() }}
                           @endif
        					<li><a class="mrg-left" href="javascript:void(0);" id="closed"><img src="{{ asset('images/icon-close.svg') }}"></a></li>
                            
        				</ul>        			
        			</div>
        		</div>
        	</div>
        </div>
        <div class="for_goal_UI_body_part">
        	<div class="row">
        		<div class="col-sm-12">
        			<div class="goal_box_item_cls">
                    <div class="for_floating_divchart">
                        <h4 class="titleheadgoal">Goal progress</h4>
                        <div class="forset_rightdr_user">
                            <div class="for_comment_showdiv">
                                <div class="user_avtar_comment"><img src="{{$goal_detail->participant->image}}"></div>
                                <div class="comment_details_user_NWUI">
                                    <h5 class="full_width blue_user">Participant</h5>
                                    <h6 class="full_width" id="participant-name">{{$goal_detail->participant->full_name}}</h6>
                                </div>
                            </div>
                            <div class="for_comment_showdiv">
                                <div class="user_avtar_comment"><img src="{{$goal_detail->provider->image}}"></div>
                                <div class="comment_details_user_NWUI">
                                    <h5 class="full_width orange_user">Provider</h5>
                                    <h6 class="full_width"  id="provider-name">{{$goal_detail->provider->full_name}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
        			
        				<div class="full_width">
                            <div id="goalprogress"></div>            
                        </div>
        			</div>
        		</div> 
        		<div class="col-sm-4">
        			<div class="goal_box_item_cls">
        				<h4 class="titleheadgoal">Scaling</h4>
        				<div class="for_scaling_box_listing">
        					@include('goal.edit._goal-scalling')
        				</div>
        			</div>
        		</div>
        		<div class="col-sm-8">
        			<div class="goal_box_item_cls">
        				<h4 class="titleheadgoal">Activity</h4>
                        @include('goal.edit._goal-activity')
        			</div>
        		</div>
        	</div>
        </div>
    </div>
</div>
@endsection
@section('extra')
<script src="{{ asset('js/pages/goal/edit.js') }}" type="text/javascript"></script>
@endsection