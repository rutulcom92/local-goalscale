<div class="form_field_cls">
   <div class="full_width">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('Organization Name *') }}
                    {{ Form::text('organization[name]', isset($organization->name) ? $organization->name : null, array('class'=>'input_control','id'=>'orgName','placeholder'=>'Organization Name'))}}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('Organization Types *') }}
                    <select name="organization_types[]" class="element_select" data-placeholder="select types" multiple="">
                        @foreach($organization_types as $key => $val)
                            @if(in_array($key,$selected_org_types))
                                <option value="{{$key}}" selected="selected">{{$val}}</option>
                            @else
                                <option value="{{$key}}">{{$val}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>   
    <div class="full_width">
        <div class="row">
            <!-- <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('Contact Email') }}
                    {{ Form::text('organization[contact_email]', isset($organization->contact_email) ? $organization->contact_email : null, array('class'=>'input_control','placeholder'=>'Contact Email','id'=>'organization_email'))}}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('Contact Phone') }}
                    {{ Form::text('organization[contact_phone]', isset($organization->contact_phone) ? $organization->contact_phone : null, array('class'=>'input_control mobile-input-mask','placeholder'=>'Contact Phone'))}}
                </div>
            </div> -->
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('Date Added *') }}
                    {{ Form::text('organization[date_added]', isset($organization->date_added) ? mdyDateFormate($organization->date_added) : null, array('class'=>'input_control datepicker-element', isset($organization->date_added) ? 'disabled="disabled"' : ''))}}
                </div>
            </div>
        </div>  
    </div>
	  <!--   <div class="full_width">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('Address *') }}
                    {{ Form::text('organization[address]', isset($organization->address) ? $organization->address : null, array('class'=>'input_control','placeholder'=>'Address'))}}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('City *') }}
                    {{ Form::text('organization[city]', isset($organization->city) ? $organization->city : null, array('class'=>'input_control','placeholder'=>'City'))}}
                </div>
            </div>
           
        </div>   -->
   <!--  </div>   
    <div class="full_width">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('Zip *') }}
                    {{ Form::text('organization[zip]', isset($organization->zip) ? $organization->zip : null, array('class'=>'input_control zip-input-mask','placeholder'=>'Zip'))}}
                </div>
            </div>
             <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('Record #') }}
                    {{ Form::number('organization[record_num]', isset($organization->record_num) ? $organization->record_num : null, array('class'=>'input_control','placeholder'=>'Record'))}}
                </div>
            </div> 
        </div>  
    </div>      -->    
</div>