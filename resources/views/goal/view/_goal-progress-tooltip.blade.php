<div class="full_width process_barTsection goal-activity-tooltip">
	<div class="goal_box_item_cls" style="padding: 0 !important">
		<div class="for_scaling_box_listing">
			 <ul>
				<li>
					<span>{{$activity->activity_ranking}}</span>
					<p>{{(!empty($goal->scales()->where('value',$activity->activity_ranking)->first()) ? $goal->scales()->where('value',$activity->activity_ranking)->first()->description : '' )}}</p>
				</li>
			</ul>
		</div>
		<div class="Wrap_all_class padzero">
		    <div class="Wrap_all_class_inner paddtopbtm">
		        <div class="for_goal_top_panle_cls">
					<div class="dynamic-comments">
						<div class="top_user_general_info full_width">
							<div class="full_width">
								<div class="top_user_general_info_left">
									<div class="user_avtar_comment"><img src="{{ $activity->owner->image }}"></div>
									<div class="comment_details_user_NWUI">
										<h5 class="full_width @if($activity->owner->user_type_id == 4) blue_user @else orange_user @endif">{{$activity->owner->userType->name}}</h5>
										<h6  class="full_width">{{$activity->owner->full_name}}<span>{{$activity->date_of_activity}}</span></h6>
										<p  class="full_width">{{$activity->update_text}}</p>
										@if(count($activity->attachments) > 0)
											<div class="for_repllabel full_width mrgtopbottmdj">Attachments</div>
											<div class="full_width attached_comm_add" style="float: left;">
												<ul>
													@foreach($activity->attachments as $attachment)
														@if(in_array(strval($attachment->namestorage),config('constants.image_mimes')))
															<li>
																<img src="{{ $attachment->name }}">
															</li>
														@else
															<!-- <li style="width: 100%"><a href="{{ $attachment->name }}">{{ $attachment->filename }}</a></li> -->
														@endif
													@endforeach
												</ul>
											</div>
										@endif
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