@extends('layouts.app-without-header')

@section('title', pageTitle('Add New Goal'))

@section('content')
{{ Form::open(['route' => 'goal.store', 'id' => 'goalForm']) }}

    <div class="Wrap_all_class padzero">
        <div class="Wrap_all_class_inner paddtopbtm">
            <div class="for_goal_UI_body_part">
                @if ($errors->any())
                    <div class="server-side-form-erros alert alert-danger mrgTop25">
                        <p>Oops! Unable to add goal. There are items that require your attention:</p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li><i class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-sm-12">
                        <div class="full_width search_bar_top_part">
                            <div class="dofortypsvret">
                                <ul>
                                    <li>
                                        <a href="{{ route('goal.index') }}"><img src="{{ asset('images/icon-close.svg') }}"></a>
                                    </li>
                                    <li><button type="submit" class="btn-cls dlminwidthy">Save</button></li>
                                </ul>
                            </div>
                            <input type="text" class="df_index_input" name="goal[name]" placeholder="Enter goal name...">                            
                        </div>
                    </div>
                    <div class="col-sm-4">
                        @include('goal.create._scaling')
                    </div>
                    <div class="col-sm-8">
                        @include('goal.create._goal-details')
                        @include('goal.create._presenting-challenges')
                        @include('goal.create._goal-topics')
                        @include('goal.create._specialized-interventions')
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('goal.create.modals._presenting-challenges-modal')
@include('goal.create.modals._goal-topics-modal')
@include('goal.create.modals._specialized-interventions-modal')

{{ Form::close() }}

@endsection

@section('extra')
<script type="text/javascript" src="{{ asset('js/jquery.mark.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/pages/goal/create.js') }}"></script>
@endsection