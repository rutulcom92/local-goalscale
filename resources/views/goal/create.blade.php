@extends('layouts.app-without-header')

@section('title','WMU | Goal Create')

@section('content')
<div class="Wrap_all_class padzero">
    <div class="Wrap_all_class_inner paddtopbtm">       
        <div class="for_goal_UI_body_part">
        	<div class="row">
        	    <div class="col-sm-12">
        	    	<div class="full_width search_bar_top_part">
        	    		<input type="text" class="df_index_input" name="">
        	    		<div class="dofortypsvret">
        	    			<ul>
        	    				<li><a href="javascript:void(0);"><img src="{{ asset('images/icon-close.svg') }}"></a></li>
        	    				<li><a href="javascript:void(0);" class="btn-cls dlminwidthy">Save</a></li>
        	    			</ul>
        	    		</div>
        	    	</div>
        	    </div>        	
        		<div class="col-sm-4">
        			<div class="goal_box_item_cls">
        				<h4 class="titleheadgoal">Scaling</h4>
        				<div class="for_scaling_box_listing">
        					<ul>
        						<li>
        							<span>4</span>
        							<p><textarea class="dectextarea" placeholder="Enter description…"></textarea></p>
        						</li>
        						<li>
        							<span>3</span>
        							<p><textarea class="dectextarea" placeholder="Enter description…"></textarea></p>
        						</li>
        						<li>
        							<span>2</span>
        							<p><textarea class="dectextarea" placeholder="Enter description…"></textarea></p>
        						</li>
        						<li>
        							<span>1</span>
        							<p><textarea class="dectextarea" placeholder="Enter description…"></textarea></p>
        						</li>
        						<li>
        							<span>0</span>
        							<p><textarea class="dectextarea" placeholder="Enter description…"></textarea></p>
        						</li>
        					</ul>
        				</div>
        			</div>
        		</div>
        		<div class="col-sm-8">
        			<div class="goal_box_item_cls">
        				<h4 class="titleheadgoal">Goal Details</h4>
        				<div class="for_activity_box_listing setmrg full_width">
        					<div class="full_width textarea_activity">
        						<div class="form_field_cls full_width">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group setmrg">
                                                <label for="First Name">Select User</label>
                                                <select class="element_select" data-placeholder="Select user">
                                                    <option value="">Select User</option>
                                                    <option>USer 1</option>
                                                    <option>USer 2</option>
                                                    <option>USer 3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group setmrg">
                                                <label for="First Name">Select Provider</label>
                                                <select class="element_select" data-placeholder="Select provider">
                                                    <option value="">Select provider</option>
                                                    <option>Provider 1</option>
                                                    <option>Provider 2</option>
                                                    <option>Provider 3</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        					</div>
        				</div>
        			</div>
                    <div class="goal_box_item_cls addgoalsf">
                        <h4 class="titleheadgoal">Presenting Challenges</h4>
                        <p>This is the presenting problem or challenge to overcome.</p>
                        <div class="for_activity_box_listing full_width">
                            <div class="full_width">
                               <ul class="badge_listing_mvb">
                                   <li><span>Integrated Dual Disorder Treatment (IDDT)</span><a href="javascript:void(0);"><i class="far fa-times"></i></a></li>
                                   <li><span>Cocaine</span><a href="javascript:void(0);"><i class="far fa-times"></i></a></li>
                                   <li><span>Cardiac</span><a href="javascript:void(0);"><i class="far fa-times"></i></a></li>
                               </ul>
                            </div>
                            <div class="full_width">
                                <div class="add_set_divcls"><a href="javascript:void(0);" data-toggle="modal" data-target="#challenges_pop"><i class="far fa-plus"></i> Add Presenting Challenges</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="goal_box_item_cls addgoalsf">
                        <h4 class="titleheadgoal">Goal Topics</h4>
                        <p>This is the subject or area of the goal on which you are working.</p>
                        <div class="for_activity_box_listing full_width">
                            <div class="full_width">
                               <ul class="badge_listing_mvb">
                                   <li><span>Isolation</span><a href="javascript:void(0);"><i class="far fa-times"></i></a></li>
                                   <li><span>Mood</span><a href="javascript:void(0);"><i class="far fa-times"></i></a></li>
                                   <li><span>Anxiety</span><a href="javascript:void(0);"><i class="far fa-times"></i></a></li>
                               </ul>
                            </div>
                            <div class="full_width">
                                <div class="add_set_divcls"><a href="javascript:void(0);"><i class="far fa-plus"></i> Add Goal Topics</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="goal_box_item_cls addgoalsf">
                        <h4 class="titleheadgoal">Specialized Interventions (optional)</h4>
                        <p>This is a specific practice or manualized intervention that you are using.</p>
                        <div class="for_activity_box_listing full_width">
                            <div class="full_width">
                               <ul class="badge_listing_mvb">
                                   <li><span>Trauma-Focused Cognitive Behavioral Therapy (TF-CBT)</span><a href="javascript:void(0);"><i class="far fa-times"></i></a></li>
                                   <li><span>Assertive Community Treatment (ACT)</span><a href="javascript:void(0);"><i class="far fa-times"></i></a></li>
                               </ul>
                            </div>
                            <div class="full_width">
                                <div class="add_set_divcls"><a href="javascript:void(0);"><i class="far fa-plus"></i> Add Specialized Interventions</a></div>
                            </div>
                        </div>
                    </div>

        		</div>
        	</div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal challenges_pop_cl" id="challenges_pop">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Presenting Challenges <span>Select all that apply</span></h4>
        <div class="pop_hd_btn">
            <button type="button" class="close btn-cls dlminwidthy" data-dismiss="modal">Cancel</button>
            <input type="submit" name="" class="pop_sb_btn btn-cls dlminwidthy" value="Submit">
        </div>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="pop_src">
            <div class="full_width">
                <input type="text" name="" class="input_clso srch" placeholder="Search">
            </div>
            <div class="acc_main">
                <div id="accordion" class="accordion">
                    <div class="card">
                        <div class="card-header" data-toggle="collapse" href="#collapseOne">
                            <a class="card-title">Health and Wellness</a>
                        </div>
                        <div id="collapseOne" class="card-body collapse show" data-parent="#accordion" >
                            <div class="check_col">                                
                                <div class="eq_col">
                                    <div class="acc_inner_col">
                                        <h3 class="col_ttl">Mental Health</h3>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Depression</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Anxiety</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Psychosis</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Post-Traumatic Stress Disorder (PTSD)</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Attention Deficit Hyperactive Disorder (ADHD)</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Obsessive Compulsive Disorder (OCD)</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Eating disorder</div>
                                            </label>
                                        </div>                                            

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Sexual disorder</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Developmental disorder</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Factitious disorder</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Financial Wellness</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="eq_col">
                                    <div class="acc_inner_col">
                                        <h3 class="col_ttl">Substance Use</h3>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="" >
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Alcohol</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Cocaine</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Nicotine</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Amphetamine</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Opioid</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Cannabis</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Prescription medication</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Hallucinogens</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="eq_col">
                                    <div class="acc_inner_col">
                                        <h3 class="col_ttl">Physical Health</h3>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="" >
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Diabetes</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Cardiac</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Seizure</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Orthopedic</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Developmental</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Cancer</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Respiratory</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            <a class="card-title">Education</a>
                        </div>
                        <div id="collapseTwo" class="card-body collapse" data-parent="#accordion" >
                            <div class="check_col">                                
                                <div class="eq_col">
                                    <div class="acc_inner_col">
                                        <h3 class="col_ttl">LEARNING DISABILITIES</h3>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">General Learning Disability</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Auditory Processing</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Dyscalculia</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Dysgraphia</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Language Processing</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Non-verbal Disorder</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Visual Perceptual</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Dyspraxia</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Executive Function</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Dyslexia</div>
                                            </label>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="eq_col">
                                    <div class="acc_inner_col">
                                        <!-- <h3 class="col_ttl">Substance Use</h3> -->
                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="" >
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Autistic Spectrum Disorder</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Fine Motor Skills / Handwriting</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Speech</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Social Skills</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Emotional disorder</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Remote Learning Environment</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Aphasia</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Spelling</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Classroom Accessibility</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Communication Skills</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            <a class="card-title">Athletics</a>
                        </div>
                        <div id="collapseThree" class="card-body collapse" data-parent="#accordion" >
                            <div class="check_col">                                
                                <div class="eq_col">
                                    <div class="acc_inner_col">
                                        <!-- <h3 class="col_ttl">LEARNING DISABILITIES</h3> -->
                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Collegiate</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">High School</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Community</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Injury</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Strength Deficit</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Flexibility Deficit</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Academic Challenge</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Eligibility</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Nutritional Deficit</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Injury Rehabilitation</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Injury Return to Sport</div>
                                            </label>
                                        </div>
                                        
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                            <a class="card-title">Business and Organizations</a>
                        </div>
                        <div id="collapseFour" class="card-body collapse" data-parent="#accordion" >
                            <div class="check_col">                                
                                <div class="eq_col">
                                    <div class="acc_inner_col">
                                        <!-- <h3 class="col_ttl">LEARNING DISABILITIES</h3> -->
                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Employee Review</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Improvement plan (PIP)</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Promotion Preparation</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Onboarding Remediation</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Onboarding</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Skill Acquisition</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Skill Enhancement</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Fund-raising / Advancement</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">                                                
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Time Management</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Emotional Intelligence</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Business / Technical Writing</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Active Listening / Business Communication</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Public Speaking</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Negotiation</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Sales Prospecting</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Sales Closing</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Sales Qualification</div>
                                            </label>
                                        </div>

                                        <div class="ch_row">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="" value="">
                                                <span class="custom-control-indicator"></span>
                                                <div class="custom-control-description">Quality / Safety</div>
                                            </label>
                                        </div>
                                        
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>

                </div>                
            </div>
        </div>
      </div>     
    </div>
  </div>
</div>
@endsection
@section('extra')

@endsection