<div class="notes_Uimain">
	<div class="form-group">
		<label>Add notes about this organization (these are private, only viewable by an admin)</label>
		<textarea class="clsheightarea" placeholder="Organization Notes" name="organization[notes]" cols="50" rows="10">{{isset($organization->notes) ? $organization->notes : null}}</textarea>
	</div>
	<span></span>
</div>