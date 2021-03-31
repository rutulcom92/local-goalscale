<div class="form_field_cls">
	<div class="full_width">
		<div class="full_width">
		<div class="wdth flt_right_rt orgranizationProgramsDt-custom-filters">
			<input type="text" placeholder="Search" class="input_clso srch datatable-common-search-input" data-table-id="orgranizationProgramsDt">
		</div>
		<div class="float-right sdopcenrt">
			<a @if(isset($id)) ? href="{{route('program.create',['org_id' => $id]) }}" @else href="{{route('program.create') }}" @endif class="btn-cls">Add New {{ isset($organization->program_label) ? $organization->program_label : 'Program' }}</a>
		</div>
			<div class="full_width margtopz">
				@include('loaders.datatables-inner-loader')
				<table class="table dt-responsive nowrap dataTable no-footer" id="orgranizationProgramsDt" style="width:100%" @if(isset($id)) ? data-ajax-url="{{ route('organization.program.list',['id' => $id]) }}" @endif >
					<thead>
						<tr>
							<th>{{ isset($organization->program_label) ? $organization->program_label : 'Program' }} Name</th>
							<th>{{ isset($organization->supervisor_label) ? $organization->supervisor_label.'s' : 'Supervisors' }}</th>
							<th># of {{ isset($organization->provider_label) ? $organization->provider_label.'s' : 'Providers' }}</th>
							<th># of {{ isset($organization->participant_label) ? $organization->participant_label.'s' : 'Participants' }}</th>
							<th># of {{ isset($organization->participant_label) ? $organization->participant_label."'s" : "Participant's" }} Goals</th>
							<th>Last Update</th>
							<th>Avg Goal Change</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
	    </div>
	</div>
</div>