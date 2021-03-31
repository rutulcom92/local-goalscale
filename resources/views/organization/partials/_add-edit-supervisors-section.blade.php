<div class="form_field_cls">
	<div class="full_width">
		<div class="full_width">                    		
    		<div class="wdth flt_right_rt organizationSupervisorsDt-custom-filters">
    			<input type="text" placeholder="Search" class="input_clso srch datatable-common-search-input" data-table-id="organizationSupervisorsDt">
    		</div>
    		<div class="float-right sdopcenrt">
    			<a @if(isset($id)) ? href="{{route('supervisor.create',['id' => $id])}}" @else  href="{{route('supervisor.create')}}" @endif class="btn-cls float-right"> Add New {{ isset($organization->supervisor_label) ? $organization->supervisor_label : 'Supervisor' }}</a>
    		</div>
    		<div class="full_width margtopz">
                @include('loaders.datatables-inner-loader')
    			<table class="table dt-responsive nowrap dataTable no-footer" id="organizationSupervisorsDt" style="width:100%" @if(isset($id)) ? data-ajax-url="{{ route('organization.supervisor.list',['id' => $id]) }}" @endif>
    				<thead>
    					<tr>
    						<th>&nbsp;</th>
    						<th>First Name</th>
    						<th>Last Name</th>
    						<th># of {{ isset($organization->provider_label) ? $organization->provider_label.'s' : 'Providers' }}</th>
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