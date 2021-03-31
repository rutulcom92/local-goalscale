<div class="full_width">
    @php ($participant_label = isset($organization->participant_label) ? $organization->participant_label : 'Participant')
    @php ($provider_label = isset($organization->provider_label) ? $organization->provider_label : 'Provider')
    <div class="full_width programGoalsDt-custom-filters">
        <div class="wdth flt_right_rt">
            {{ Form::select('filter_by_provider', [' ' => 'Filter by '.$provider_label]+ $providers->toArray(), null ,array('class' => 'datatable-custom-filter element_select', 'data-placeholder' => 'Filter by '.$provider_label, 'data-table-id' => 'programGoalsDt')) }}
        </div>
        <div class="wdth flt_right_rt">
            {{ Form::select('filter_by_participant', [' ' => 'Filter by '.$participant_label]+ $participants->toArray(), null ,array('class' => 'datatable-custom-filter element_select', 'data-placeholder' => 'Filter by '. $participant_label, 'data-table-id' => 'programGoalsDt')) }}
        </div>
        <div class="wdth flt_right_rt">
            <input type="text" placeholder="Search" class="input_clso srch datatable-common-search-input" data-table-id="programGoalsDt">
        </div>
        <div class="float-right sdopcenrt">
            <a href="{{route('goal.create')}}" class="btn-cls float-right"> Add New Goal</a>
        </div>
    </div>
    <div class="full_width">
        <div class="margtopz">
            @include('loaders.datatables-inner-loader')
            <table class="table dt-responsive nowrap dataTable no-footer" id="programGoalsDt" style="width:100%" @if(isset($id)) ? data-ajax-url="{{ route('program.goal.list',['id' => $id]) }}" @endif>
                <thead>
                    <tr>
                        <th>Goal Title</th>
                        <th>{{ isset($organization->participant_label) ? $organization->participant_label : 'Participant' }}</th>
                        <th>{{ isset($organization->provider_label) ? $organization->provider_label : 'Provider' }}</th>
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
    </div>
</div>
