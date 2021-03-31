<div class="form_field_cls supervisorProgramsDt-custom-filters">
	<div class="full_width">
		<div class="wdth">
			<input type="text" placeholder="Search" class="input_clso srch datatable-common-search-input" data-table-id="supervisorProgramsDt">
		</div>
	</div>
</div>   
<div class="full_width margtopz">
	@include('loaders.datatables-inner-loader')
	<table id="supervisorProgramsDt" class="table dt-responsive nowrap" style="width:100%" data-ajax-url="{{ route('supervisor.program.list',['id' => $id]) }}">
		<thead>
			<tr>
				<th>Name</th>
				<th># of {{ isset($organization->provider_label) ? $organization->provider_label.'s' : 'Providers' }}</th>
				<th># of Users</th>
				<th># of User's Goals</th>
				<th>Last Update</th>
				<th>Avg Goal Change</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>