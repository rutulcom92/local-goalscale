<div class="form_field_cls">
	<div class="full_width">
		<div class="full_width programProvidersDt-custom-filters">
    		<div class="wdth flt_right_rt">
    			<input type="text" placeholder="Search" class="input_clso srch datatable-common-search-input" data-table-id="programProvidersDt">
    		</div>
    		<div class="float-right sdopcenrt">
    			<a @if(isset($id)) ? href="{{route('provider.create',['pid' => $id])}}" @else  href="{{route('provider.create')}}" @endif class="btn-cls float-right"> Add New Provider</a>
            </div>
    	</div>
        <div class="full_width">
        	<div class="margtopz">
                @include('loaders.datatables-inner-loader')
    			<table class="table dt-responsive nowrap dataTable no-footer" id="programProvidersDt" style="width:100%" @if(isset($id)) ? data-ajax-url="{{ route('program.provider.list',['id' => $id]) }}" @endif>
    				<thead>
    					<tr>
    						<th>&nbsp;</th>
    						<th>First Name</th>
    						<th>Last Name</th>
    						<th># of {{ isset($organization->participant_label) ? $organization->participant_label.'s' : 'Participants' }}</th>
    						<th># of {{ isset($organization->participant_label) ? $organization->participant_label."'s" : "Participant's" }} Goals</th>
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