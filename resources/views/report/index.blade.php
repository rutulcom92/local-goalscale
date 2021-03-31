@extends('layouts.app')

@section('title','WMU | Reports')

@section('content')
<style type="text/css">
    .ui-tabs .ui-tabs-hide {
        position: absolute;
        top: -10000px;
        display: block !important;
    }

    span.select2 {
        display: table;
        /*    table-layout    : fixed;*/
        width: 100% !important;
        height: 100% !important;
    }

    .highcharts-point {
        width: 3px;
    }
</style>
<div class="Wrap_all_class">
    <div class="Wrap_all_class_inner">
        <div class="full_width Tabs_cls_cool">
            <nav>
                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Organization Reports</a>
                    <a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">Goal Reports</a>
                </div>
            </nav>
            <div class="tab-content setclsdformulti" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="tb_hd_nw_rpt">
                        <h1 class="title_All_R_t">Reports on organization and program data</h1>
                        <div class="filter_cls_wmu drop-org">
                            <ul class="participantsDt-custom-filters">
                                <li class="mrg-left wdth">
                                    <label>Organization(s)</label>
                                    <select name="organization_id[]" class="select2m org-report-filter" multiple="multiple" data-placeholder="" id="organizationId">
                                        @foreach($organizations as $key => $val)
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </li>

                                <li class="mrg-left wdth">
                                    <label>Programs(s)</label>
                                    <select name="program_id[]" class="select2m org-report-filter" multiple="multiple" data-placeholder="" id="programId">
                                        @foreach($programs as $key => $val)
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </li>
                                <li class="mrg-left wdth">
                                    <label>Start Date</label>
                                    <input type="text" name="goal_start_date" class="input_clso datepicker-element org-dreport-filter" id="ostart-date" data-placeholder="">
                                </li>

                                <li class="mrg-left wdth">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" name="goal_end_date" class="input_clso datepicker-element org-dreport-filter" id="oend-date" data-placeholder="">
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="full_width mobres_des">
                        <div class="row">
                            <div class="col-sm-4 setc">
                                <div class="Place_box_report">
                                    <h6>Average goal change by program</h6>
                                    <div class="load-avg-goal-graph" data-get-average-goal-change-by-program-graph-details-ajax-url="{{route('reports.get-average-goal-change-by-program-graph-details')}}"></div>
                                    <div class="full_width mrgtop20">
                                        <div id="avg_goal" class="sm_chart" style="min-height:120px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 setc">
                                <div class="Place_box_report">
                                    <h6>Goal Progress by Program</h6>
                                    <div class="load-per-goal-graph" data-get-goal-performance-by-program-graph-details-ajax-url="{{route('reports.get-goal-performance-by-program-graph-details')}}"></div>
                                    <div class="full_width mrgtop20">
                                        <div id="per_goal" class="sm_chart" style="min-height:120px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 setcc">
                                <div class="Place_box_report">
                                    <h6>Goal progress by program and provider type</h6>
                                    <div class="load-pro-goal-graph" data-get-goal-progress-by-program-providertype-graph-details-ajax-url="{{route('reports.get-goal-progress-by-program-providertype-graph-details')}}"></div>
                                    <div class="full_width mrgtop20">
                                        <div id="pro_goal" class="sm_chart" style="min-height:130px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                    <div class="tb_hd_nw_rpt">
                        <h1 class="title_All_R_t">Reports on goal data</h1>
                        <div class="filter_cls_wmu">
                            <ul class="participantsDt-custom-filters">
                                <li class="mrg-left wdth">
                                    <label>Presenting Challenge</label>
                                    <select name="presenting_challenges" class="presenting_challenges select2g goal-report-filter" id="presenting-challenge" multiple="true" data-placeholder="">
                                        @foreach($presentingChallengeTags as $tagKey => $tag)
                                        <option value="{{$tag->id}}">{{$tag->tag}}</option>
                                        @endforeach
                                    </select>
                                </li>

                                <li class="mrg-left wdth">
                                    <label>Goal Topic</label>
                                    <select name="goal_topics" class="goal_topics select2g goal-report-filter" id="goal-topic" multiple="true" data-placeholder="">
                                        @foreach($goalTopicTags as $tagKey => $tag)
                                        <option value="{{$tag->id}}">{{$tag->tag}}</option>
                                        @endforeach
                                    </select>
                                </li>

                                <li class="mrg-left wdth">
                                    <label>Specialized Intervention</label>
                                    <select name="specialized_interventions" class="specialized_interventions select2g goal-report-filter" id="specialized-invention" multiple="true" data-placeholder="">
                                        @foreach($specializedInterventionTags as $tagKey => $tag)
                                        <option value="{{$tag->id}}">{{$tag->tag}}</option>
                                        @endforeach
                                    </select>
                                </li>

                                <li class="mrg-left wdth">
                                    <label>Start Date</label>
                                    <input type="text" name="goal_start_date" class="input_clso datepicker-element goal-greport-filter" id="gstart-date" data-placeholder="">
                                </li>

                                <li class="mrg-left wdth">
                                    <label>End Date</label>
                                    <input type="text" name="goal_end_date" class="input_clso datepicker-element goal-greport-filter" id="gend-date" data-placeholder="End date">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="full_width mobres_des">
                        <div class="row">
                            <div class="col-sm-12 setc">
                                <div class="Place_box_report">
                                    <h6>Goal progress by goal topic and presenting challenge</h6>
                                    <div class="load-pro-goal1-graph" data-get-goal-topic-presenting-challenge-graph-details-ajax-url="{{route('reports.get-goal-topic-presenting-challenge-graph-details')}}"></div>
                                    <div class="full_width mrgtop20">





                                        <div id="pro_goal1" class="sm_chart" style="min-height:200px;"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 setc">
                                <div class="Place_box_report">
                                    <h6>Goal progress by goal topic and specialized intervention</h6>
                                    <div class="load-pro-goal2-graph" data-get-goal-topic-specialized-intervention-graph-details-ajax-url="{{route('reports.get-goal-topic-specialized-intervention-graph-details')}}"></div>
                                    <div class="full_width mrgtop20">
                                        <div id="pro_goal2" class="sm_chart" style="min-height:150px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 setc">
                                <div class="Place_box_report">
                                    <h6>Goal progress by presenting challenge and specialized intervention</h6>
                                    <div class="load-pro-goal3-graph" data-get-goal-presenting-challenge-specialized-intervention-graph-details-ajax-url="{{route('reports.get-goal-presenting-challenge-specialized-intervention-graph-details')}}"></div>
                                    <div class="full_width mrgtop20">
                                        <div id="pro_goal3" class="sm_chart" style="min-height:150px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('extra')
<script src="{{ asset('js/pages/report/index.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/report/goal.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/report/organization.js') }}" type="text/javascript"></script>

@endsection