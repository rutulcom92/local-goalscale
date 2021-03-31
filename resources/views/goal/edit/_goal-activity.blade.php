<div class="for_activity_box_listing full_width">
	<div class="load-graph" data-get-goal-graph-ajax-url = "{{route('goal.get-graph-details')}}"></div> 
	{{ Form::open(array('route' => array('goal.update', $goal_detail->id), 'id' => 'goalActivityForm', 'files' => 'true')) }}
    @method('PUT')
	<input type="hidden" name="goal_id" value="{{$goal_detail->id}}" class="goal_id">
	<input type="hidden" name="goal[activity_ranking]" value="" class="activity_ranking">
	<input type="file" name="goal_attachments[]" class="attachments" id="file-attachments" multiple="true" style="display: none;">
	<div class="full_width textarea_activity">
		<div class="emoji-picker-container">
			<textarea class="textarea_activity_input" id="activityInput" data-emojiable="true"  placeholder="Add an update (limit to 191 characters)..." name="goal[update_text]" ></textarea>
		</div>
 
		<ul>
			<li><a href="javascript:void(0);" class="activity-attchment"><img src="{{ asset('images/icon-attachment.svg') }}"></a></li>
			<li class="open-emoji"><a href="javascript:void(0);"><img src="{{ asset('images/icon-emoji.svg') }}"></a></li>
		</ul>
	</div>
	<div class="full_width margtopz">
		<input type="hidden" class="remove-file-icon" value="{{ asset('images/icon-remove-file.png') }}">
		<ul class="activity-attchments-display">
		
		</ul>
	</div>
	<div class="full_width margtopz">
		<label>Progress</label>
		<div class="forPro_listingbar" id="goal-progress">
			<span id="0">0</span>
			<span id="1">1</span>
			<span id="2">2</span>
			<span id="3">3</span>
			<span id="4">4</span>
		</div>
		
		<div class="full_width padtpbtn1525">
			<input type="submit" class="sm_nwUIbtn forcgb" value="Save Changes">			
		</div>	
	</div>
	{{ Form::close() }}
	<div class="full_width process_barTsection">
		<div class="user_commentsection_UImain full_width">
			<div class="user_commentsection_inner full_width">
				<!-- <div class="top_user_general_info full_width">
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
				</div> -->
				
				<input type="hidden" name="last_activity_id" value="{{(!empty($goal_detail->activities()->orderBy('id','DESC')->first()) ?  ($goal_detail->activities()->orderBy('id','DESC')->limit(5)->get()->max('id')+1) : 0 )}}" class="last_activity_id">
				<div class="dynamic-comments">
				</div>
                <div class="load_more_UI">
                    <a href="javascript:void(0);" class="load-activities" data-get-goal-activities-ajax-url = "{{route('goal.get-activities')}}"><span>Load More</span><img src="{{ asset('images/down-arrow.svg') }}"></a>
                </div>
			</div>
		</div>
	</div>
</div>