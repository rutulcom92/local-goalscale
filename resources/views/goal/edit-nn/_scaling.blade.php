<div class="goal_box_item_cls">
    <h4 class="titleheadgoal">Scaling</h4>
    <div class="for_scaling_box_listing">
        <ul>
            @foreach(goalScale() as $key => $value)
                <li>
                    <span>{{ $value }}</span>
                    <p>
                        <textarea class="dectextarea goal-scale-description" placeholder="Enter description..." name="goal[scale][{{ $key }}]"></textarea>
                    </p>
                </li>    
            @endforeach
        </ul>
    </div>
</div>