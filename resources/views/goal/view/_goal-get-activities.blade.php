@foreach($activities as $activity)
	<div class="top_user_general_info full_width">
		<div class="full_width">
			<div class="top_user_general_info_left">
				<div class="user_avtar_comment"><img src="{{ $activity->owner->image }}"></div>
				<div class="comment_details_user_NWUI">
					<h5 class="full_width @if($activity->owner->user_type_id == 4) blue_user @else orange_user @endif">{{$activity->owner->userType->name}}</h5>
					<h6  class="full_width">{{$activity->owner->full_name}}<span>{{$activity->date_of_activity}}</span></h6>
					<p  class="full_width">{{$activity->update_text}}</p>
					<div class="for_replydiv full_width activity-replay-{{$activity->id}}"><a data-id="{{$activity->id}}" class="activity-replay" data-get-goal-activity-replay-ajax-url = "{{route('goal.get-activity-replay',['id' => $activity->id ])}}" href="javascript:void(0);">Reply</a></div>
					@if(isset($activity->attachments) && count($activity->attachments) > 0)
						<div class="for_repllabel full_width mrgtopbottmdj">Attachments</div>
						<div class="full_width attached_comm_add">
							<ul>
								@foreach($activity->attachments as $attachment)
									@if(in_array(strval($attachment->namestorage),config('constants.image_mimes')))
										<li>
											<img src="{{ $attachment->name }}">
										</li>
									@else
										<li style="width: 100%"><a href="{{ $attachment->name }}">{{ $attachment->filename }}</a></li>
									@endif
								@endforeach
							</ul>
						</div>
					@endif
				</div>
			</div>
			<div class="top_user_general_info_right">
				<p>Updated Progress</p>
				<div class="forPro_listingbar text-center">
					<span class="@if($activity->owner->user_type_id == 4) blue_progress @else org_progress @endif">{{$activity->activity_ranking}}</span>
				</div>
			</div>
			<div class="full_width padd_left_60">
				@foreach($activity->childActivities()->get() as $child)
				    <div class="for_comment_showdiv">
						<div class="user_avtar_comment"><img src="{{ $child->owner->image }}"></div>
						<div class="comment_details_user_NWUI">
							<h5 class="full_width @if($activity->owner->user_type_id == 4) blue_user @else orange_user @endif">{{$child->owner->userType->name}}</h5>
							<h6  class="full_width">{{$child->owner->full_name}}<span>{{$child->date_of_activity}}</span></h6>
							<p  class="full_width">{{$child->update_text}}</p>
						</div>
						@if(count($child->attachments) > 0)
						   <div class="for_repllabel full_width mrgtopbottmdj">Attachments</div>
							<div class="full_width attached_comm_add">
								<ul>
									@foreach($child->attachments as $attachment)
										@if(in_array(mime_content_type($attachment->namestorage),config('constants.image_mimes')))
											<li>
												<img src="{{ $attachment->name }}">
											</li>
										@else
											<li style="width: 100%"><a href="{{ $attachment->name }}">{{ $attachment->filename }}</a></li>
										@endif
									@endforeach
								</ul>
							</div>
						@endif
					</div>      									
				@endforeach	
			</div>
		</div>
	</div>
@endforeach