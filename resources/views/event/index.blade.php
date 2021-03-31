@extends('layouts.app')

@section('title','WMU | Log Events')

@section('content')
<div class="Wrap_all_class">
     <div class="Wrap_all_class_inner">
        <div class="top_filter formobile_screen">
        	<div class="row">
        		<div class="col-sm-2">
        			<h1>Log Events</h1>
        		</div>
        		<div class="col-sm-10">
        			<div class="filter_cls_wmu">
        				<ul class="eventsDt-custom-filters">
							<li class="mrg-left wdth100">
								<input type="text" name="event_to_date" class="input_clso datepicker-element org-dreport-filter datatable-custom-filter" placeholder="To Date" data-placeholder="" data-table-id="eventsDt">
							</li>
							<li class="mrg-left wdth100">
								<input type="text" name="event_from_date" class="input_clso datepicker-element org-dreport-filter datatable-custom-filter" placeholder="From Date" data-placeholder="" data-table-id="eventsDt">
							</li>
							<li class="mrg-left wdth">
        						<select class="element_select datatable-custom-filter" data-table-id="eventsDt" name="userType">
        							<option value="">Filter by User Type</option>
        							@foreach($userTypes as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
        						</select>
        					</li>
							<li class="mrg-left wdth">
        						<select class="element_select datatable-custom-filter" data-table-id="eventsDt" name="eventName">
        							<option value="">Filter by Event Name</option>
        							@foreach($eventNames as $key => $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
        						</select>
        					</li>
                            <li class="mrg-left wdth150">
        						<select class="element_select datatable-custom-filter" data-table-id="eventsDt" name="eventType">
        							<option value="">Filter by Event Type</option>
        							@foreach($eventTypes as $key => $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
        						</select>
        					</li>
                            <li class="mrg-left wdth">
        						<input type="text" placeholder="Search" class="input_clso srch datatable-common-search-input" data-table-id="eventsDt">
        					</li>
        				</ul>
        			</div>
        		</div>
        	</div>
        </div>
        <div class="for_content_section">
            @include('loaders.datatables-inner-loader')
        	<!-- <table class="table dt-responsive nowrap" id="eventsDt" style="width:100%" data-ajax-url="{{ route('event.list') }}"> -->
            <table id="eventsDt" class="table dt-responsive nowrap event-tbl" style="width:100%" data-ajax-url="{{ route('event.list') }}">
        		<thead>
        			<tr>
						<th>Event Type</th>
						<th>Event Name</th>
                        <th>Description</th>
						<th>Related ID</th>
						<th>Email</th>
        				<th>Event User Type</th>
        				<th>Event User Name</th>
        				<th>Created At</th>
        				<!-- <th>Actions</th> -->
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
<script src="{{ asset('js/pages/event/index.js') }}" type="text/javascript"></script>
@endsection
