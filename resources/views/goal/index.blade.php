@extends('layouts.app')

@section('title','WMU | Goal')

@section('content')
<div class="Wrap_all_class">
    <div class="Wrap_all_class_inner">
        <div class="top_filter">
        	<div class="row">
        		<div class="col-sm-2">
        			<h1>Goals</h1>
        		</div>
        		<div class="col-sm-10">
        			<div class="filter_cls_wmu nw_filter">
        				<ul class="goalsDt-custom-filters">
                            @if(Auth::user()->user_type_id != participantUserTypeId())
        					<li class="mrg-left">
        						<a href="{{ route('goal.create') }}" class="btn-cls">Add New Goal</a>
							</li>
							<li class="mrg-left import-goal">
								<div class="btn-group">
									<button type="button" class="btn-cls dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Import Goals
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item" href="javascript:showImportForm();">Import Now</a>
										<a class="dropdown-item" href="{{ url('uploads/import-goals-sample.csv') }}">Download Sample File</a>
									</div>
								</div>
								<!-- <select class="element_select datatable-custom-filter" name="import-goals">
									<option value="import_goals">Import Goals</option>
									<option value="download_sample">Download Sample File</option>
								</select> -->
							</li>
							<!-- <li class="mrg-left">
        						<a href="javascript:void(0);" onclick="showImportForm()" class="btn-cls">Import Goals</a>
        					</li> -->
        					<li class="mrg-left wdth">
        						<select class="element_select datatable-custom-filter" data-table-id="goalsDt" name="participant">
        							<option value="">Filter by Participant</option>
        							@foreach($participants as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->full_name }}</option>
                                    @endforeach
        						</select>
        					</li>
                            @endif
        					<li class="mrg-left wdth">
        						<select class="element_select datatable-custom-filter" data-table-id="goalsDt" name="tag">
        							<option value="">Filter by Tag</option>
        							@foreach($tags as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->tag }}</option>
                                    @endforeach
        						</select>
        					</li>
        					<li class="mrg-left wdth">
        						<select class="element_select datatable-custom-filter" data-table-id="goalsDt" name="organization">
                                    <option value="">Filter by Organization</option>
                                    @foreach($organizations as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
        					</li>
        					<li class="mrg-left wdth">
        						<input type="text" placeholder="Search" class="input_clso srch datatable-common-search-input" data-table-id="goalsDt">
        					</li>
        				</ul>
        			</div>
        		</div>
        	</div>
        </div>
        <div class="for_content_section">

            @include('loaders.datatables-inner-loader')

        	<table id="goalsDt" class="table dt-responsive nowrap goal-tbl" style="width:100%" data-ajax-url="{{ route('goal.list') }}">
        		<thead>
        			<tr>
        				<th>Goal Title</th>
        				<th>Participant</th>
        				<th>Provider</th>
        				<th>Date Created</th>
        				<th>Last Update</th>
        				<th>Tags</th>
        				<th>Goal Change</th>
        				<th>Status</th>
                        @if(Auth::user()->user_type_id == superAdminUserTypeId() || Auth::user()->user_type_id == supervisorUserTypeId())
                            <th>Actions</th>
                        @endif
        			</tr>
        		</thead>
        		<tbody>
        		</tbody>
        	</table>
        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal challenges_pop_cl" id="import_goals_pop">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<!-- Modal Header -->
      		<div class="modal-header">
        		<h4 class="modal-title">Import Goals</span></h4>
        		<div class="pop_hd_btn">
            		<button type="button" class="close btn-cls dlminwidthy" data-dismiss="modal">Close</button>
            		<input type="submit" name="" class="pop_sb_btn btn-cls dlminwidthy import-goal-action" value="Submit">
        		</div>
      		</div>
      		<!-- Modal body -->
      		<div class="modal-body">
        		<div class="pop_src text-center">
					<div class="col-md-12 import-file-box">
						<div class="card card-body">
							<div class="d-flex justify-content-center align-items-center">
								<div class="custom-file w-50">
									<input type="file" name="goalImportFile" class="custom-file-input import-goal-file-input" id="goalImportFile" data-import-goal-ajax-url="<?php echo e(route('goal.import')); ?>" accept=".csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
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
<script type="text/javascript" src="{{ asset('js/pages/goal/index.js') }}"></script>
@endsection
