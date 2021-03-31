@extends('layouts.app')

@section('title','WMU | Participant')

@section('content')
<div class="Wrap_all_class">
     <div class="Wrap_all_class_inner">
        <div class="top_filter">
            <div class="row">
                <div class="col-sm-2">
                    <h1>Participants</h1>
                </div>  
                <div class="col-sm-10">
                    <div class="filter_cls_wmu">
                        <ul class="participantsDt-custom-filters">
                            <li class="mrg-left">
                                <a href="{{ route('participant.create') }}" class="btn-cls">Add New Participant</a>
                            </li>
                            @if(Auth::user()->user_type_id != providerUserTypeId())
                            <li class="mrg-left wdth">
                                {{ Form::select('filter_by_provider_type', [' ' => 'Filter by Provider Type']+ $provider_types->toArray(), null ,array('class' => 'datatable-custom-filter element_select', 'data-placeholder' => 'Filter by Provider Type', 'data-table-id' => 'participantsDt')) }}
                            </li>
                            @endif
                            <li class="mrg-left wdth">
                                  {{ Form::select('filter_by_program', [' ' => 'Filter by Program']+ $programs->toArray(), null ,array('class' => 'datatable-custom-filter element_select', 'data-placeholder' => 'Filter by Program', 'data-table-id' => 'participantsDt')) }}
                            </li>
                            <li class="mrg-left wdth">
                                {{ Form::select('filter_by_organization', [' ' => 'Filter by Organization']+ $organizations->toArray(), null ,array('class' => 'datatable-custom-filter element_select', 'data-placeholder' => 'Filter by Organization', 'data-table-id' => 'participantsDt')) }}
                            </li>
                            <li class="mrg-left wdth">
                                <input type="text" placeholder="Search" class="input_clso srch datatable-common-search-input" data-table-id="participantsDt">
                            </li>
                        </ul>
                    </div>
                </div>  
            </div>
        </div>
        <div class="for_content_section">
            @include('loaders.datatables-inner-loader')
            <table id="participantsDt" class="table dt-responsive nowrap" style="width:100%" data-ajax-url="{{ route('participant.list') }}">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th># of Goals</th>
                        <th>Last Update</th>
                        <th>Organization</th>
                        <th>Provider</th>
                        <th>Goal Change</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('extra')
<script src="{{ asset('js/pages/participant/index.js') }}" type="text/javascript"></script>
@endsection