<div class="notes_Uimain">
	<div class="form-group">
		<label>Add notes about this program (these are private, only viewable by an admin)</label>
		<textarea class="clsheightarea" placeholder="Program Notes" name="program[notes]" cols="50" rows="10">{{isset($program->notes) ? $program->notes : null}}</textarea>
	</div>
	<span></span>
</div>