<select name="user_programs[program_id][]" class="multi_select_element sel_programs" multiple="multiple" data-tags="true", data-placeholder="Please Select">
	@foreach($programs as $key => $val)
		<option value="{{$key}}">{{$val}}</option>
	@endforeach
</select>