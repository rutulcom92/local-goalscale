<div class="modal fade" id="siteContentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('route' => "dashboard.welcome-to-goal.store", 'class' => '', 'id' => 'siteContentForm','files' => 'true')) }}
                {{ Form::hidden('sitecontent[reference_key]','welcome_to_goal_attainment_scaling')}}
                <div class="modal-header">
                    <h4 class="modal-title">Welcome to Goal Attainment Scaling!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="{{ asset('images/icon-close.png') }}"></button>
                </div>
                <div class="modal-body">
                    <div class="full_width">
                        <div class="top-content">
                        	<div class="color_des">
                                <label>Content</label>
                                <div class="form-group mrbtm48">
                                	{{ Form::textarea('sitecontent[content]', isset($welcome_content->content) ? $welcome_content->content : "GAS is a method of measuring goal attainment over time, using a five-point scale to capture all possible outcomes for a given goal. GAS is a unique approach to goal setting, one that promotes success along a continuum rather than the traditional all-or-nothing success vs. failure model.  It has been used in healthcare and educational settings since 1968. Numerous studies have found GAS to be highly sensitive to change, unlike other measures that use a generic and broad evaluation, not specific to the needs of each individual. The ability to capture small but meaningful change over time makes it a preferred outcome measure among clinicians, researchers, teachers, and caregivers." , array('class' => "form-control welcome-info")) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input class="btn-cls float-right" type="submit" value="Save">
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>