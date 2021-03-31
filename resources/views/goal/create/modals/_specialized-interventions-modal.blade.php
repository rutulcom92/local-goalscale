<div class="modal challenges_pop_cl fade" id="specializedInterventionsModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Specialized Interventions <span>Select all that apply</span></h4>
                <div class="pop_hd_btn">
                    <button type="button" class="close btn-cls dlminwidthy" data-dismiss="modal">Cancel</button>
                    <input type="button" class="pop_sb_btn btn-cls dlminwidthy save-specialized-interventions" value="Submit">
                </div>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="pop_src">
                    <div class="full_width">
                        <input type="text" class="input_clso srch specialized-interventions-search" placeholder="Search">
                    </div>
                    <div class="acc_main specialized-interventions-primary-container">
                        <div id="specializedInterventionsAccordion" class="accordion">
                            
                            @foreach($orgTypes as $orgTypeKey => $orgType)
                                
                                <div class="card">
                                    <div class="card-header collapsed" data-toggle="collapse" href="#collapseSpecializedInterventionsOrgType{{ $orgType->id }}">
                                        <a class="card-title">{{ $orgType->name }}</a>
                                    </div>
                                    <div id="collapseSpecializedInterventionsOrgType{{ $orgType->id }}" class="card-body collapse">
                                        <div class="check_col">
                                            
                                            @foreach($orgType->specializedInterventionTags->sortBy('tag')->groupBy('group.name')->sortKeys() as $tagGroup => $tags)

                                                <div class="eq_col">
                                                    <div class="acc_inner_col">
                                                        @if(!empty($tagGroup))
                                                            <h3 class="col_ttl">{{ $tagGroup }}</h3>
                                                        @endif

                                                        @foreach($tags as $tagKey => $tag)
                                                            <div class="ch_row specialized-interventions-checkbox-container">
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input specialized-interventions-checkbox" name="goal[tags][{{ $tag->id }}]" value="{{ $tag->id }}">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <div class="custom-control-description">{{ $tag->tag }}</div>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>