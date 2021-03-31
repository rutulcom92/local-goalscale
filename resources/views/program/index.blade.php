@extends('layouts.app')

@section('title','WMU | Program')

@section('content')
<div class="Wrap_all_class">
     <div class="Wrap_all_class_inner">
        <div class="top_filter formobile_screen">
        	<div class="row">
        		<div class="col-sm-2">
        			<h1>Program</h1>
        		</div>	
        		<div class="col-sm-10">
        			<div class="filter_cls_wmu">
        				<ul class="organizationsDt-custom-filters">
        					<li class="mrg-left">
        						<a href="{{route('program.create')}}" class="btn-cls">Add New Program</a>
        					</li>
        					<li class="mrg-left wdth">
                                <input type="text" placeholder="Search" class="input_clso srch datatable-common-search-input" data-table-id="programsDt">
        					</li>
        				</ul>
        			</div>
        		</div>	
        	</div>
        </div>
        <div class="for_content_section">
            @include('loaders.datatables-inner-loader')
        	<table class="table dt-responsive nowrap" id="programsDt" style="width:100%" data-ajax-url="{{ route('program.list') }}">
        		<thead>
        			<tr>
        				<th>Program Name</th>
        				<th>Supervisors</th>
        				<th># of Providers</th>
        				<th># of Participants</th>
        				<th># of Participant's Goal</th>
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
@endsection


@section('extra')
<script src="{{ asset('js/pages/program/index.js') }}" type="text/javascript"></script>
@endsection