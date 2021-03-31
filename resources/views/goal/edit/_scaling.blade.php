<div class="goal_box_item_cls">
    <h4 class="titleheadgoal">Scaling</h4>
    <div class="for_scaling_box_listing">
        <ul>
            @if(Auth::user()->user_type_id == superAdminUserTypeId() || Auth::user()->user_type_id == supervisorUserTypeId())
                @foreach(goalScale() as $key => $value)
                    <li>
                        <span>{{ $value }}</span>
                        <p>
                            <textarea class="dectextarea goal-scale-description" placeholder="Enter description..." name="goal[scale][{{ $key }}]">{{(!empty($goal_detail->scales()->where('value',strval($value))->first()) ? $goal_detail->scales()->where('value',strval($value))->first()->description : '' )}}</textarea>
                        </p>
                    </li>
                @endforeach
            @else
                @foreach(goalScale() as $key => $value)
                    <li>
                        <span>{{ $value }}</span>
                        <p>
                            {{(!empty($goal_detail->scales()->where('value',strval($value))->first()) ? $goal_detail->scales()->where('value',strval($value))->first()->description : '' )}}
                        </p>
                    </li>
                @endforeach`
            @endif
        </ul>
    </div>
</div>
