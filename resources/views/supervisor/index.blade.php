@extends('layouts.app')

@section('title','WMU | Supervisor')

@section('content')
<div class="Wrap_all_class">
   <div class="Wrap_all_class_inner">
        <div class="top_filter">
        	<div class="row">
        		<div class="col-sm-3">
        			<h1>Supervisors</h1>
        		</div>	
        		<div class="col-sm-9">
        			<div class="filter_cls_wmu">
        				<ul class="supervisorsDt-custom-filters">
        					<li class="mrg-left">
        						<a href="{{ route('supervisor.create') }}" class="btn-cls">Add New Supervisor</a>
        					</li>
        					<li class="mrg-left wdth">
                                {{ Form::select('filter_by_program', [' ' => 'Filter by Program']+ $programs->toArray(), null ,array('class' => 'datatable-custom-filter element_select', 'data-placeholder' => 'Filter by Program', 'data-table-id' => 'supervisorsDt')) }}
        					</li>
                            <li class="mrg-left wdth">
                                {{ Form::select('filter_by_organization', [' ' => 'Filter by Organization']+ $organizations->toArray(), null ,array('class' => 'datatable-custom-filter element_select', 'data-placeholder' => 'Filter by Organization', 'data-table-id' => 'supervisorsDt')) }}
                            </li>
        					<li class="mrg-left wdth">
        						<input type="text" placeholder="Search" class="input_clso srch datatable-common-search-input" data-table-id="supervisorsDt">
        					</li>
        				</ul>
        			</div>
        		</div>	
        	</div>
        </div>
        <div class="for_content_section">
            @include('loaders.datatables-inner-loader')
        	<table id="supervisorsDt" class="table dt-responsive nowrap" style="width:100%" data-ajax-url="{{ route('supervisor.list') }}">
        		<thead>
        			<tr>
        				<th>&nbsp;</th>
        				<th>First Name</th>
        				<th>Last Name</th>
                        <th># of Providers</th>
        				<th># of Participants</th>
        				<th># of Participant’s Goals</th>
        				<th>Organization</th>
                        <th>Programs</th>
        				<th>Last Sign In</th>
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
@endsection
@section('extra')
<script src="{{ asset('js/pages/supervisor/index.js') }}" type="text/javascript"></script>
@endsection