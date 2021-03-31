<div class="form_field_cls">
	<div class="full_width">
		@php ($program_label = isset($organization->program_label) ? $organization->program_label : 'Program')
		@php ($provider_label = isset($organization->provider_label) ? $organization->provider_label : 'Provider')
		<div class="full_width organizationprovidersDt-custom-filters">  
			<div class="wdth flt_right_rt">
                {{ Form::select('filter_by_program', [' ' => 'Filter by '.$program_label]+ $programs->toArray(), null ,array('class' => 'datatable-custom-filter element_select', 'data-placeholder' => 'Filter by '.$program_label, 'data-table-id' => 'organizationprovidersDt')) }}
			</div>   
			<div class="wdth flt_right_rt">
				{{ Form::select('filter_by_provider_type', [' ' => 'Filter by '.$provider_label.' Type']+ $provider_types->toArray(), null ,array('class' => 'datatable-custom-filter element_select', 'data-placeholder' => 'Filter by '.$provider_label.' Type', 'data-table-id' => 'organizationprovidersDt')) }}
			</div>                		
    		<div class="wdth flt_right_rt">
    			<input type="text" placeholder="Search" class="input_clso srch datatable-common-search-input" data-table-id="organizationprovidersDt">
    		</div>
    		<div class="float-right sdopcenrt">
    			<a @if(isset($id)) ? href="{{route('provider.create',['id' => $id])}}" @else  href="{{route('provider.create')}}" @endif class="btn-cls float-right"> Add New {{ isset($organization->provider_label) ? $organization->provider_label : 'Provider' }}</a>
            </div>
    	</div>
        <div class="full_width">
        	<div class="margtopz">
                @include('loaders.datatables-inner-loader')
    			<table class="table dt-responsive nowrap dataTable no-footer" id="organizationprovidersDt" style="width:100%" @if(isset($id)) ? data-ajax-url="{{ route('organization.provider.list',['id' => $id]) }}" @endif>
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
		</div>
	</div>
</div>