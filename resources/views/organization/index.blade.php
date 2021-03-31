@extends('layouts.app')

@section('title','WMU | Organization')

@section('content')
<div class="Wrap_all_class">
     <div class="Wrap_all_class_inner">
        <div class="top_filter formobile_screen">
        	<div class="row">
        		<div class="col-sm-2">
        			<h1>Organizations</h1>
        		</div>
        		<div class="col-sm-10">
        			<div class="filter_cls_wmu">
        				<ul class="organizationsDt-custom-filters">
        					<li class="mrg-left">
        						<a href="{{route('organization.create')}}" class="btn-cls">Add New Organization</a>
        					</li>
							@if(Auth::user()->isSuperAdmin())
							<li class="mrg-left import-goal">
								<div class="btn-group">
									<button type="button" class="btn-cls dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Import Users
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item" href="javascript:showImportForm();">Import Now</a>
										<a class="dropdown-item" href="{{ url('uploads/import-users-sample.csv') }}">Download Sample File</a>
									</div>
								</div>
								<!-- <select class="element_select datatable-custom-filter" name="import-goals">
									<option value="import_goals">Import Goals</option>
									<option value="download_sample">Download Sample File</option>
								</select> -->
							</li>
							@endif
        					<li class="mrg-left wdth">
                                {{ Form::select('filter_by_program', [' ' => 'Filter by Program']+ $programs->toArray(), null ,array('class' => 'datatable-custom-filter element_select', 'data-placeholder' => 'Filter by Program', 'data-table-id' => 'organizationsDt')) }}
        					</li>
        					<li class="mrg-left wdth">
                                <input type="text" placeholder="Search" class="input_clso srch datatable-common-search-input" data-table-id="organizationsDt">
        					</li>
        				</ul>
        			</div>
        		</div>
        	</div>
        </div>
        <div class="for_content_section">
            @include('loaders.datatables-inner-loader')
        	<table class="table dt-responsive nowrap" id="organizationsDt" style="width:100%" data-ajax-url="{{ route('organization.list') }}">
        		<thead>
        			<tr>
        				<th>Organization Name</th>
<!--        				<th>Location</th>-->
        				<th># of Providers</th>
        				<th># of Participants</th>
        				<th>Programs</th>
        				<th>Avg Goal Change</th>
        			</tr>
        		</thead>
        		<tbody>
        		</tbody>
        	</table>
        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal challenges_pop_cl" id="import_users_pop">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<!-- Modal Header -->
      		<div class="modal-header">
        		<h4 class="modal-title">Import Users</span></h4>
        		<div class="pop_hd_btn">
            		<button type="button" class="close btn-cls dlminwidthy" data-dismiss="modal">Close</button>
            		<input type="submit" name="" class="pop_sb_btn btn-cls dlminwidthy import-users-action" value="Submit">
        		</div>
      		</div>
      		<!-- Modal body -->
      		<div class="modal-body">
        		<div class="pop_src text-center">
					<div class="col-md-12 import-file-box">
						<div class="card card-body">
							<div class="d-flex justify-content-center align-items-center">
								<div class="custom-file w-50">
									<input type="file" name="userImportFile" class="custom-file-input import-users-file-input" id="userImportFile" data-import-users-ajax-url="<?php echo e(route('user.import')); ?>" accept=".csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
									<label class="custom-file-label" for="customFile">Choose a CSV or Excel file</label>
								</div>
							</div>
						</div>
					</div>

					<div id="csv_file_data" class="col-md-12 mt-5 import-data">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('extra')
<script src="{{ asset('js/pages/organization/index.js') }}" type="text/javascript"></script>
@endsection
