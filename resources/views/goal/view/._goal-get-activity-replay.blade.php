{{ Form::open(array('route' => array('goal.activity.replay', $activity->id), 'id' => 'goalActivityReplayForm', 'files' => 'true')) }}
    @method('PUT')
	<input type="file" name="goal_attachments[]" class="attachments" id="file-attachments" multiple="true" style="display: none;">
	<div class="full_width textarea_activity">
		<textarea class="textarea_activity_input" placeholder="Add an update..." name="goal[update_text]" data-emojiable="true" data-emoji-input="unicode"></textarea>
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
		<div class="full_width padtpbtn1525">
			<input type="submit" class="sm_nwUIbtn forcgb" value="Save Changes">			
		</div>	
	</div>
{{ Form::close() }}