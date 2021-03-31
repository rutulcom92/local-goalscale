@extends('layouts.app-without-header')

@section('title','WMU | Add New Goal')

@section('content')
<div class="Wrap_all_class padzero">
    <div class="Wrap_all_class_inner paddtopbtm">
        <div class="for_goal_top_panle_cls">
        	<div class="row align-items-center">
        		<div class="col-sm-8">
        			<div class="for_title_goal_UIclsd">
        				<h2>Shyness</h2>
        				<div class="for_tags_cls_goal">
        					<label>Tags:</label>
        					<ul>
        						<li>Social Anxiety</li>
        						<li>Public Speaking</li>
        					</ul>
        				</div>
        			</div>
        		</div>
        		<div class="col-sm-4">
        			<div class="right_bar_top_profile for_ctc_goal_UI">
        				<ul>
        					<li><a href="{{ url('goal/goalDetailExport') }}" class="sm_nwUIbtn">Export to PDF</a></li>
        					<li><a href="{{url('/')}}/goal" id="closed"><img src="{{ asset('images/icon-close.svg') }}"></a></li>
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
                                <div class="user_avtar_comment"><img src="{{url('/')}}/public/images/1.jpg"></div>
                                <div class="comment_details_user_NWUI">
                                    <h5 class="full_width blue_user">User</h5>
                                    <h6 class="full_width">Winnie Gordon</h6>
                                </div>
                            </div>
                            <div class="for_comment_showdiv">
                                <div class="user_avtar_comment"><img src="{{url('/')}}/public/images/5.jpg"></div>
                                <div class="comment_details_user_NWUI">
                                    <h5 class="full_width orange_user">Provider</h5>
                                    <h6 class="full_width">Robert Castillo</h6>
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
        					<ul>
        						<li>
        							<span>4</span>
        							<p>Unable to decrease shyness by engaging in at least 3 group leading activities with a clear, loud voice</p>
        						</li>
        						<li>
        							<span>3</span>
        							<p>Able to decrease shyness by engaging in at least 1-2 group leading activities with a clear, loud voice</p>
        						</li>
        						<li>
        							<span>2</span>
        							<p>Able to decrease shyness by engaging in at least 3 group leading activities with a clear, loud voice</p>
        						</li>
        						<li>
        							<span>1</span>
        							<p>Able to decrease shyness by engaging in at least 4 group leading activities with a clear, loud voice</p>
        						</li>
        						<li>
        							<span>0</span>
        							<p>Able to decrease shyness by engaging in at least 5 group leading activities with a clear, loud voice</p>
        						</li>
        					</ul>
        				</div>
        			</div>
        		</div>
        		<div class="col-sm-8">
        			<div class="goal_box_item_cls">
        				<h4 class="titleheadgoal">Activity</h4>
        				<div class="for_activity_box_listing full_width">
        					<div class="full_width textarea_activity">
        						<textarea class="textarea_activity_input" placeholder="Add an update..."></textarea>
        						<ul>
        							<li><a href="javascript:void(0);"><img src="{{ asset('images/icon-attachment.svg') }}"></a></li>
        							<li><a href="javascript:void(0);"><img src="{{ asset('images/icon-emoji.svg') }}"></a></li>
        						</ul>
        					</div>
        					<div class="full_width process_barTsection">
        						<label>Progress</label>
        						<div class="forPro_listingbar">
        							<span>0</span>
        							<span>1</span>
        							<span>2</span>
        							<span>3</span>
        							<span>4</span>
        						</div>
        						<div class="full_width padtpbtn1525">
        							<a href="javascript:void(0);" class="sm_nwUIbtn forcgb">Submit</a>
        						</div>
        						<div class="user_commentsection_UImain full_width">
        							<div class="user_commentsection_inner full_width">
        								<div class="top_user_general_info full_width">
	        								<div class="full_width">
	        									<div class="top_user_general_info_left">
	        										<div class="user_avtar_comment"><img src="{{ asset('images/1.jpg') }}"></div>
	        										<div class="comment_details_user_NWUI">
	        											<h5 class="full_width blue_user">User</h5>
	        											<h6  class="full_width">Winnie Gordon<span>9/15/19, 10:34 AM</span></h6>
	        											<p  class="full_width">I went to 6 leading activities in the last week</p>
	        											<div class="for_replydiv full_width"><a href="javascript:void(0);">Reply</a></div>
	        											<div class="for_repllabel full_width">3 replies</div>
	        										</div>
	        									</div>
	        									<div class="top_user_general_info_right">
	        										<p>Updated Progress</p>
	        										<div class="forPro_listingbar text-center">
					        							<span>0</span>
					        						</div>
	        									</div>
	        								</div>
	    									<div class="full_width padd_left_50">
	    									    <div class="for_comment_showdiv">
	        										<div class="user_avtar_comment"><img src="{{ asset('images/5.jpg') }}"></div>
	        										<div class="comment_details_user_NWUI">
	        											<h5 class="full_width orange_user">Provider</h5>
	        											<h6  class="full_width">Robert Castillo<span>9/15/19, 11:02 AM</span></h6>
	        											<p  class="full_width">Nice job!</p>
	        										</div>
	    										</div>   
	    										<div class="for_comment_showdiv">
	        										<div class="user_avtar_comment"><img src="{{ asset('images/1.jpg') }}"></div>
	        										<div class="comment_details_user_NWUI">
	        											<h5 class="full_width blue_user">User</h5>
	        											<h6  class="full_width">Winnie Gordon<span>9/15/19, 2:07 PM</span></h6>
	        											<p  class="full_width">Thank you, Robert.</p>
	        										</div>
	    										</div>   
	    										<div class="for_comment_showdiv">
	        										<div class="user_avtar_comment"><img src="{{ asset('images/5.jpg') }}"></div>
	        										<div class="comment_details_user_NWUI">
	        											<h5 class="full_width orange_user">Provider</h5>
	        											<h6  class="full_width">Robert Castillo<span>9/15/19, 11:02 AM</span></h6>
	        											<p  class="full_width">You bet. Keep up the good work!</p>
	        										</div>
	    										</div>        										
	    									</div>
        								</div>

        								<div class="top_user_general_info full_width">
	        								<div class="full_width">
	        									<div class="top_user_general_info_left">
	        										<div class="user_avtar_comment"><img src="{{ asset('images/5.jpg') }}"></div>
	        										<div class="comment_details_user_NWUI">
	        											<h5 class="full_width orange_user">Provider</h5>
	        											<h6  class="full_width">Winnie Gordon<span>9/15/19, 10:34 AM</span></h6>
	        											<p  class="full_width">Winnie went to 4 leading activities over the weekend</p>
	        											<div class="for_replydiv full_width"><a href="javascript:void(0);">Reply</a></div>
	        										</div>
	        									</div>
	        									<div class="top_user_general_info_right">
	        										<p>Updated Progress</p>
	        										<div class="forPro_listingbar text-center">
					        							<span class="org_progress">1</span>
					        						</div>
	        									</div>
	        								</div>
        								</div>


        								<div class="top_user_general_info full_width">
	        								<div class="full_width">
	        									<div class="top_user_general_info_left">
	        										<div class="user_avtar_comment"><img src="{{ asset('images/1.jpg') }}"></div>
	        										<div class="comment_details_user_NWUI">
	        											<h5 class="full_width blue_user">User</h5>
	        											<h6  class="full_width">Winnie Gordon<span>9/15/19, 10:34 AM</span></h6>
	        											<p  class="full_width">I went to 4 leading activities over the weekend. Photos attached!</p>
	        											<div class="for_replydiv full_width"><a href="javascript:void(0);">Reply</a></div>
	        											<div class="for_repllabel full_width mrgtopbottmdj">Attachments</div>
	        											<div class="full_width attached_comm_add">
	        												<ul>
	        													<li><img src="{{ asset('images/m2.jpg') }}"></li>
	        													<li><img src="{{ asset('images/m1.jpg') }}"></li>
	        												</ul>
	        											</div>
	        										</div>
	        									</div>
	        									<div class="top_user_general_info_right">
	        										<p>Updated Progress</p>
	        										<div class="forPro_listingbar text-center">
					        							<span>2</span>
					        						</div>
	        									</div>
	        								</div>
        								</div>

        								<div class="top_user_general_info full_width">
	        								<div class="full_width">
	        									<div class="top_user_general_info_left">
	        										<div class="user_avtar_comment"><img src="{{ asset('images/5.jpg') }}"></div>
	        										<div class="comment_details_user_NWUI">
	        											<h5 class="full_width orange_user">Provider</h5>
	        											<h6  class="full_width">Winnie Gordon<span>9/15/19, 10:34 AM</span></h6>
	        											<p  class="full_width">Winnie had a decline and only went to 3 leading activities this week. She has 4 planned for next week.</p>
	        											<div class="for_replydiv full_width"><a href="javascript:void(0);">Reply</a></div>
	        										</div>
	        									</div>
	        									<div class="top_user_general_info_right">
	        										<p>Updated Progress</p>
	        										<div class="forPro_listingbar text-center">
					        							<span class="org_progress">2</span>
					        						</div>
	        									</div>
	        								</div>
        								</div>

                                        <div class="load_more_UI">
                                            <a href="javascript:void(0);"><span>Load More</span><img src="{{ asset('images/down-arrow.svg') }}"></a>
                                        </div>
        							</div>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>
    </div>
</div>
@endsection
@section('extra')
<script src="{{ asset('js/pages/goal/add_edit.js') }}" type="text/javascript"></script>
@endsection