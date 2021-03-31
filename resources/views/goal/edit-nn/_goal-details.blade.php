<div class="goal_box_item_cls">
    <h4 class="titleheadgoal">Goal Details</h4>
    <div class="for_activity_box_listing setmrg full_width">
        <div class="full_width textarea_activity">
            <div class="form_field_cls full_width">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group setmrg">
                            <label>Select Provider</label>
                            <select class="element_select goal-provider" name="goal[provider_id]">
                                @if(Auth::user()->user_type_id != 3)
                                    <option value=" ">Select Provider</option>
                                @endif
                                @foreach($providers as $key => $provider)
                                    <option value="{{ $provider->id }}">{{ $provider->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group setmrg">
                            <label>Select Participant</label>
                            <select class="element_select goal-participant" name="goal[participant_id]" data-participants-ajax-url="{{ route('goal.provider.participants') }}">
                                <option value=" ">Select Participant</option>
                                @foreach($participants as $key => $participant)
                                    <option value="{{ $participant->id }}">{{ $participant->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>