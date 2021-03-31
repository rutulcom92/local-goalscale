<div class="form_field_cls supervisorProvidersDt-custom-filters">
	<div class="full_width">
		<div class="wdth">
			<input type="text" placeholder="Search" class="input_clso srch datatable-common-search-input" data-table-id="supervisorProvidersDt">
		</div>
	</div>
</div>   
<div class="full_width margtopz">
	@include('loaders.datatables-inner-loader')
	<table id="supervisorProvidersDt" class="table dt-responsive nowrap" style="width:100%" data-ajax-url="{{ route('supervisor.provider.list',['id' => $id]) }}">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th># of {{ isset($organization->participant_label) ? $organization->participant_label.'s' : 'Participants' }}</th>
				<th># of {{ isset($organization->participant_label) ? $organization->participant_label."'s" : "Participant's" }} Goals</th>
				<th>{{ isset($organization->program_label) ? $organization->program_label : 'Program' }}</th>
				<th>Last Update</th>
				<th>Goal Change</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>