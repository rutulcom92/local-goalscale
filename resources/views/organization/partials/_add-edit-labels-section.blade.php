<div class="form_field_cls">
   <div class="full_width">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('Program Label *') }}
                    {{ Form::text('organization[program_label]', isset($organization->program_label) ? $organization->program_label : 'Program', array('class'=>'input_control','id'=>'program_label','placeholder'=>'Program Label'))}}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('Supervisor Label *') }}
                    {{ Form::text('organization[supervisor_label]', isset($organization->supervisor_label) ? $organization->supervisor_label : 'Supervisor', array('class'=>'input_control','id'=>'supervisor_label','placeholder'=>'Supervisor Label'))}}
                </div>
            </div>
        </div>
    </div>   
    <div class="full_width">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('Provider Label *') }}
                    {{ Form::text('organization[provider_label]', isset($organization->provider_label) ? $organization->provider_label : 'Provider', array('class'=>'input_control','id'=>'provider_label','placeholder'=>'Supervisor Label'))}}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('Participant Label *') }}
                    {{ Form::text('organization[participant_label]', isset($organization->participant_label) ? $organization->participant_label : 'Participant', array('class'=>'input_control','placeholder'=>'Participant Label','id'=>'participant_label'))}}
                </div>
            </div>
        </div>  
    </div>  
</div>