<div class="Wrap_all_classx">
    <div class="Wrap_all_class_innerx">
		<!-- <div class="row">
			<div class="card">
				<div class="card-header">
				</div>
				<div class="card-body">
					<div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
						<div class="form-group">
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="customFile">
								<label class="custom-file-label" for="customFile">Upload File</label>
							</div>
						</div>
						<div class="py-4"></div>
					</div>
				</div>
			</div>
		</div> -->
		<div class="mb-5">
			<div class="card col-md-12">
				<div class="card-body">
					<div class="text-center">
						<span class="h5">The goal data below will be imported</span>						
						<div class="pop_hd_btn mt-2">
							<button type="button" data-import-goal-ajax-url="<?php echo e(route('goal.import.post')); ?>" class="import-continue btn-cls">Continue</button>
							<!-- <button type="button" class="close btn-cls dlminwidthy" data-dismiss="modal">Cancel</button> -->
						</div>
					</div>
				</div>
			</div>
		</div>
        <div class="for_content_section mb-5">
        	<table id="goalsDtImp" class="table dt-responsive nowrap goal-import-tbl" style="width:100%">
				<thead>
        			<tr>
        				<th>Goal Title</th>
        				<th>Participant</th>
        				<th>Provider</th>
        				<th>Tags</th>
        				<th>Sacaling-0</th>
        				<th>Sacaling-1</th>
        				<th>Sacaling-2</th>
        				<th>Sacaling-3</th>
						<th>Sacaling-4</th>
        			</tr>
        		</thead>
				<tbody>
					@foreach($importdata as $key => $value)
						<tr>
							<td>{{ isset($value['goal_name'])?$value['goal_name']:'' }}</td>
							<td>{{ isset($value['participant_email'])?$value['participant_email']:'' }}</td>
							<td>{{ isset($value['provider_email'])?$value['provider_email']:'' }}</td>
							<td>{{ isset($value['tags'])?$value['tags']:'' }}</td>
							<td>{{ isset($value['scaling0'])?$value['scaling0']:'' }}</td>
							<td>{{ isset($value['scaling1'])?$value['scaling1']:'' }}</td>
							<td>{{ isset($value['scaling2'])?$value['scaling2']:'' }}</td>
							<td>{{ isset($value['scaling3'])?$value['scaling3']:'' }}</td>
							<td>{{ isset($value['scaling4'])?$value['scaling4']:'' }}</td>
						</tr>
					@endforeach
        		</tbody>
        	</table>
        </div>
    </div>
</div>
