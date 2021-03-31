<div class="Wrap_all_classx">
    <div class="Wrap_all_class_innerx">
		<div class="mb-5">
			<div class="card col-md-12">
				<div class="card-body">
					<div class="text-center">
						<span class="h5">The user data below will be imported</span>						
						<div class="pop_hd_btn mt-2">
							<button type="button" data-import-users-ajax-url="<?php echo e(route('user.import.post')); ?>" class="import-continue btn-cls">Continue</button>
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
        				<th>First Name</th>
        				<th>Last Name</th>
        				<th>User Type</th>
        				<th>Email</th>
						<th>Password</th>
        				<th>Phone</th>
        				<th>Address</th>
        				<th>City</th>
        				<th>State</th>
						<th>Zip</th>
						<th>Organization</th>
        			</tr>
        		</thead>
				<tbody>
					@foreach($importdata as $key => $value)
						<tr>
							<td>{{ isset($value['first_name'])?$value['first_name']:'' }}</td>
							<td>{{ isset($value['last_name'])?$value['last_name']:'' }}</td>
							<td>{{ isset($value['user_type'])?$value['user_type']:'' }}</td>
							<td>{{ isset($value['email'])?$value['email']:'' }}</td>
							<td>{{ isset($value['password'])?$value['password']:'' }}</td>
							<td>{{ isset($value['phone'])?$value['phone']:'' }}</td>
							<td>{{ isset($value['address'])?$value['address']:'' }}</td>
							<td>{{ isset($value['city'])?$value['city']:'' }}</td>
							<td>{{ isset($value['state'])?$value['state']:'' }}</td>
							<td>{{ isset($value['zip'])?$value['zip']:'' }}</td>
							<td>{{ isset($value['organization'])?$value['organization']:'' }}</td>
						</tr>
					@endforeach
        		</tbody>
        	</table>
        </div>
    </div>
</div>
