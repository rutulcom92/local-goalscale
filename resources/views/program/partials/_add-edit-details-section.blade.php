<div class="form_field_cls">
  <div class="full_width">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label(isset($organization->program_label) ? $organization->program_label.' Name *' : 'Program Name *') }}
                    {{ Form::text('program[name]', isset($program->name) ? $program->name : null, array('class'=>'input_control','placeholder'=>'Program Name','id'=>'program_name'))}}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('Organization *') }}
                    @if(isset($org_id))
                    {{ Form::text('org_name', isset($org_id) ? $organization_name->name : null, array('class'=>'input_control','placeholder'=>'Organization Name','disabled'=>'disabled'))}}
                    {{ Form::hidden('program[organization_id]', isset($org_id) ? $org_id : null, array('class'=>'input_control','placeholder'=>'Organization Name','id'=>'organization_id'))}}
                    @else
                    {{ Form::select('program[organization_id]', ['' => 'Please Select']+ $organizations->toArray(), isset($program->organization_id) ? $program->organization_id : null ,array('class' => 'element_select','id'=>'organization_id')) }}
                    @endif
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('Date Added *') }}
                    {{ Form::text('program[date_added]', isset($program->date_added) ? mdyDateFormate($program->date_added) : date("m/d/Y"), array('class'=>'input_control datepicker-element', isset($program->date_added) ? 'disabled="disabled"' : ''))}}
                </div>
            </div>
        </div>
    </div>
</div>