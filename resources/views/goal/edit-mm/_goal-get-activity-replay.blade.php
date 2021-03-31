<div class="modal fade" id="goalActivityReplayModal">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('route' => array('goal.activity.replay', $activity->id), 'id' => 'goalActivityReplayForm', 'files' => 'true')) }}
    		    <div class="modal-header">
                    <h4 class="modal-title">Activity Reply</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="{{ asset('images/icon-close.png') }}"></button>
                </div>
                <div class="modal-body">
                    <input type="file" name="activity_replay_attachments[]" class="replay-attachments" multiple="true" id="replay-attachments" style="display: none;">

					<div class="full_width textarea_activity" id="replay-activity">
						<textarea class="textarea_activity_input" placeholder="Add a reply..." name="update_text" data-emojiable="true"></textarea>
						<ul>
							<li><a href="javascript:void(0);" class="activity-replay-attchment"><img src="{{ asset('images/icon-attachment.svg') }}"></a></li>
							<li class="open-replay-emoji"><a href="javascript:void(0);"><img src="{{ asset('images/icon-emoji.svg') }}"></a></li>
						</ul>
					</div>
					<div class="full_width margtopz">
						<ul class="activity-replay-attchments-display">
						</ul>
					</div>
					<!-- <div class="full_width margtopz">
						<div class="full_width padtpbtn1525">
							<input type="submit" class="sm_nwUIbtn forcgb" value="Save Changes">
						</div>	
					</div> -->
                </div>
                <div class="modal-footer">
                    <input class="btn-cls float-right" type="submit" value="Save">
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>