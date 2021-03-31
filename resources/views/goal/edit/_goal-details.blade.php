<div class="goal_box_item_cls">
    <h4 class="titleheadgoal">Goal Details</h4>
    <div class="for_activity_box_listing setmrg full_width">
        <div class="full_width textarea_activity">
            <div class="form_field_cls full_width">
                <div class="row">
                    <div class="forset_rightdr_user">                            
                        <div class="col-sm-5 for_comment_showdiv">
                            <div class="user_avtar_comment"><img src="{{$goal_detail->provider->image}}"></div>
                            <div class="comment_details_user_NWUI">
                                <h5 class="full_width orange_user">Provider</h5>
                                <h6 class="full_width"  id="provider-name">{{$goal_detail->provider->full_name}}</h6>
                            </div>
                            <input type="hidden" id="provider_id" name="goal[provider_id]" value="{{ $goal_detail->provider->id }}">
                        </div>
                        <div class="col-sm-5 for_comment_showdiv">
                            <div class="user_avtar_comment"><img src="{{$goal_detail->participant->image}}"></div>
                            <div class="comment_details_user_NWUI">
                                <h5 class="full_width blue_user">Participant</h5>
                                <h6 class="full_width" id="participant-name">{{$goal_detail->participant->full_name}}</h6>
                            </div>
                            <input type="hidden" id="participant_id"  name="goal[participant_id]" value="{{ $goal_detail->participant->id }}">
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>