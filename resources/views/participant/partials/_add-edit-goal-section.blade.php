<div class="form_field_cls">
	<div class="full_width">
		<div class="wdth">
			<input type="text" placeholder="Search" class="input_clso srch datatable-common-search-input"  data-table-id="participantGoalsDt"">
		</div>
	</div>
	</div>   
	<div class="full_width margtopz">
	@include('loaders.datatables-inner-loader')
	<table id="participantGoalsDt" class="table dt-responsive nowrap" style="width:100%" @if(isset($id)) ? data-ajax-url="{{ route('participant.goal.list',['id' => $id]) }}" @endif">
		<thead>
			<tr>
				<th>Goal Title</th>
				<th>Date Created</th>
				<th>Last Update</th>
				<th>Tags</th>
				<th>Goal Change</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>              