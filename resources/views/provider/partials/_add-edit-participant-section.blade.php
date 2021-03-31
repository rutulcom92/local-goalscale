<div class="form_field_cls">
	<div class="full_width providerParticipantsDt-custom-filters">
		@php ($participant_label = isset($organization->participant_label) ? $organization->participant_label : 'Participant')
		<div class="wdth flt_right_rt">
			{{ Form::select('filter_by_participant', [' ' => 'Filter by '.$participant_label.'s']+ $participants->toArray(), null ,array('class' => 'datatable-custom-filter element_select', 'data-placeholder' => 'Filter by '.$participant_label.'s', 'data-table-id' => 'providerParticipantsDt')) }}
		</div>
		<div class="wdth flt_right_rt">
			<input type="text" placeholder="Search" class="input_clso srch datatable-common-search-input" data-table-id="providerParticipantsDt">
		</div>
	</div>
</div> 
<div class="full_width margtopz">
	@include('loaders.datatables-inner-loader')
    <table id="providerParticipantsDt" class="table dt-responsive nowrap" style="width:100%" @if(isset($id)) ? data-ajax-url="{{ route('provider.participant.list',['id' => $id]) }}" @endif">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th># of Goals</th>
				<th>Last Update</th>
				<th>Goal Change</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>