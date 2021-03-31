<div class="form_field_cls">
   <div class="full_width">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('Program Label *') }}
                    {{ Form::text('organization[program_label]', $admin->program_label, array('class'=>'input_control','id'=>'program_label','placeholder'=>'Program Label'))}}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('Supervisor Label *') }}
                    {{ Form::text('organization[supervisor_label]', $admin->supervisor_label, array('class'=>'input_control','id'=>'supervisor_label','placeholder'=>'Supervisor Label'))}}
                </div>
            </div>
        </div>
    </div>   
    <div class="full_width">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('Provider Label *') }}
                    {{ Form::text('organization[provider_label]', $admin->provider_label, array('class'=>'input_control','id'=>'provider_label','placeholder'=>'Supervisor Label'))}}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('Participant Label *') }}
                    {{ Form::text('organization[participant_label]', $admin->participant_label, array('class'=>'input_control','placeholder'=>'Participant Label','id'=>'participant_label'))}}
                </div>
            </div>
        </div>  
    </div>  
</div>