@extends('layouts.app')

@section('title','WMU | Provider')

@section('content')
<div class="Wrap_all_class">
    <div class="Wrap_all_class_inner">
        <div class="top_filter formobile_screen">
        	<div class="row">
        		<div class="col-sm-2">
        			<h1>Providers</h1>
        		</div>	
        		<div class="col-sm-10">
        			<div class="filter_cls_wmu">
        				<ul class="providersDt-custom-filters">
        					<li class="mrg-left">
        						<a href="{{ route('provider.create') }}" class="btn-cls">Add New Provider</a>
        					</li>
        					<li class="mrg-left wdth">
        						{{ Form::select('filter_by_provider_type', [' ' => 'Filter by Provider Type']+ $provider_types->toArray(), null ,array('class' => 'datatable-custom-filter element_select', 'data-placeholder' => 'Filter by Provider Type', 'data-table-id' => 'providersDt')) }}
        					</li>
        					<li class="mrg-left wdth">
        						{{ Form::select('filter_by_program', [' ' => 'Filter by Program']+ $programs->toArray(), null ,array('class' => 'datatable-custom-filter element_select', 'data-placeholder' => 'Filter by Program', 'data-table-id' => 'providersDt')) }}
        					</li>
                            @if(Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 5)
            					<li class="mrg-left wdth">
            						{{ Form::select('filter_by_organization', [' ' => 'Filter by Organization']+ $organizations->toArray(), null ,array('class' => 'datatable-custom-filter element_select', 'data-placeholder' => 'Filter by Organization', 'data-table-id' => 'providersDt')) }}
            					</li>
                            @endif
        					<li class="mrg-left wdth">
        						<input type="text" placeholder="Search" class="input_clso srch datatable-common-search-input" data-table-id="providersDt">
        					</li>
        				</ul>
        			</div>
        		</div>	
        	</div>
        </div>
        <div class="for_content_section">
            @include('loaders.datatables-inner-loader')
        	<table class="table dt-responsive nowrap" id="providersDt" style="width:100%" data-ajax-url="{{ route('provider.list') }}">
        		<thead>
        			<tr>
        				<th>&nbsp;</th>
        				<th>First Name</th>
        				<th>Last Name</th>
        				<th># of Participants</th>
        				<th># of Participant’s Goals</th>
        				<th>Organization</th>
                        <th>Program</th>
                        <th>Provider Type</th>
        				<th>Last Update</th>
        				<th>Goal Change</th>
                        <th>Status</th>
        			</tr>
        		</thead>
        		<!-- <tbody>
        			<tr>
        				<td><div class="for_user"><img src="{{ asset('images/1.jpg') }}"></div></td>
        				<td>Warren</td>
        				<td>Mills</td>
        				<td>22</td>
        				<td>201</td>
        				<td>Bronson Hospital</td>
        				<td>Sep 15, 2019</td>
        				<td>+3.2</td>
        			</tr>
        		</tbody> -->
        	</table>
        </div>
    </div>
</div>
@endsection
@section('extra')
<script src="{{ asset('js/pages/provider/index.js') }}" type="text/javascript"></script>
@endsection