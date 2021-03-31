
<div class="full_width">
	@php ($provider_label = isset($organization->provider_label) ? $organization->provider_label : 'Provider')
	<div class="full_width OrgParticipantsDt-custom-filters">
		<div class="wdth flt_right_rt">
			 {{ Form::select('filter_by_provider', [' ' => 'Filter by '.$provider_label]+ $providers->toArray(), null ,array('class' => 'datatable-custom-filter element_select', 'data-placeholder' => 'Filter by '.$provider_label, 'data-table-id' => 'OrgParticipantsDt')) }}
		</div>
			<div class="wdth flt_right_rt">
				<input type="text" placeholder="Search" class="input_clso srch datatable-common-search-input" data-table-id="OrgParticipantsDt">
			</div>
			<div class="float-right sdopcenrt">
				<a @if(isset($id)) ? href="{{route('participant.create',['id' => $id])}}" @else  href="{{route('participant.create')}}" @endif class="btn-cls float-right"> Add New {{ isset($organization->participant_label) ? $organization->participant_label : 'Participant' }}</a>
			</div>
	</div>
	<div class="full_width">
		<div class="margtopz">
			@include('loaders.datatables-inner-loader')
			<table class="table dt-responsive nowrap dataTable no-footer" id="OrgParticipantsDt" style="width:100%" @if(isset($id)) ? data-ajax-url="{{ route('organization.participant.list',['id' => $id]) }}" @endif>
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th># of Goals</th>
						<th>Last Update</th>
						<th>{{ isset($organization->program_label) ? $organization->program_label : 'Program' }}</th>
						<th>{{ isset($organization->provider_label) ? $organization->provider_label : 'Provider' }}</th>
						<th>Goal Change</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>
