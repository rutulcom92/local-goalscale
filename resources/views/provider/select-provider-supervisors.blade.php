@foreach($supervisors as $key => $val)
<div class="col-sm-3">
	<div class="form-group">
	{{ Form::label(isset($organization->supervisor_label) ? $organization->supervisor_label .' : '. $val['program_name'].' *' : 'Supervisor : '. $val['program_name'].' *') }}
		<select name="provider_supervisor[supervisor_id][]" class="multi_select_element select2-element sel_supervisor" data-placeholder="Please Select" id="provider_supervisor_{{$val['program_id']}}" multiple="multiple"> 
			<option>Please Select</option>
			@foreach($val['data'] as $key1 => $supervisor)
				<option value="{{$supervisor->id}},{{$val['program_id']}}">{{$supervisor->full_name}}</option>
			@endforeach
		</select>
	</div>
</div>
@endforeach