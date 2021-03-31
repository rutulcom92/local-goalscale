<select name="userDetail[provider_type_id]" class="select_element sel_providerType" data-placeholder="Please Select">
	@if(!isset($orgID))
	<option>Please Select</option> 
	@endif
	@foreach($providerTypes as $key => $val)
		<option value="{{$key}}">{{$val}}</option>
	@endforeach
</select>