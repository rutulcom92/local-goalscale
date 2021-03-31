<div class="full_width">
	<div class="full_width programUsersDt-custom-filters">
		@php ($provider_label = isset($organization->provider_label) ? $organization->provider_label : 'Provider')
		<div class="wdth flt_right_rt">
			 {{ Form::select('filter_by_provider', [' ' => 'Filter by '.$provider_label]+ $providers->toArray(), null ,array('class' => 'datatable-custom-filter element_select', 'data-placeholder' => 'Filter by '.$provider_label, 'data-table-id' => 'programUsersDt')) }}
		</div>
		<div class="wdth flt_right_rt">
			<input type="text" placeholder="Search" class="input_clso srch datatable-common-search-input" data-table-id="programUsersDt">
		</div>
		<div class="float-right sdopcenrt">
			<a @if(isset($id)) ? href="{{route('participant.create',['pid' => $id])}}" @else  href="{{route('participant.create')}}" @endif class="btn-cls float-right"> Add New Participant</a>
        </div>
	</div>
    <div class="full_width">
    	<div class="margtopz">
    		@include('loaders.datatables-inner-loader')
			<table class="table dt-responsive nowrap dataTable no-footer" id="programUsersDt" style="width:100%" @if(isset($id)) ? data-ajax-url="{{ route('program.user.list',['id' => $id]) }}" @endif>
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th># of Goals</th>
						<th>Last Update</th>
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
