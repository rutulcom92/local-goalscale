<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrganizationType;
use App\Models\Organization;
use App\Models\Program;
use Auth;
use App\Models\Tag;

class ReportController extends Controller
{
    public function index()
    {


        if(Auth::user()->user_type_id == superAdminUserTypeId()){
            $orgType = OrganizationType::orderBy('name', 'ASC')->get();
            $organizations = Organization::orderBy('name', 'ASC')->get()->pluck('name','id');
            $programs = Program::orderBy('name', 'ASC')->get()->pluck('name','id');
            $goalTopicTags = Tag::where('tag_type_id','2')->orderBy('tag','ASC')->get();
            $presentingChallengeTags = Tag::where('tag_type_id','1')->orderBy('tag','ASC')->get();
            $specializedInterventionTags = Tag::where('tag_type_id','3')->orderBy('tag','ASC')->get();
           
            // foreach($orgType as $orgTypeKey => $orgType){
            //     pr($orgType->goalTopicTags->sortBy('tag')->groupBy('group.name')->sortKeys());exit();
            // }die;
        }else if(Auth::user()->user_type_id == supervisorUserTypeId() || Auth::user()->user_type_id == organizationAdminUserTypeId()){
            $orgType = OrganizationType::whereHas('organizationOrgType',function($query){
                $query->where('organization_id',Auth::user()->organization_id);
            })->orderBy('name', 'ASC')->get();
            $organizations = Organization::whereId(Auth::user()->organization_id)->orderBy('name', 'ASC')->get()->pluck('name','id');
            $programs = Program::orderBy('name', 'ASC')->where('organization_id',Auth::user()->organization_id)->get()->pluck('name','id');
            $goalTopicTags = Tag::where('tag_type_id','2')->orderBy('tag','ASC')->get();
            $presentingChallengeTags = Tag::where('tag_type_id','1')->orderBy('tag','ASC')->get();
            $specializedInterventionTags = Tag::where('tag_type_id','3')->orderBy('tag','ASC')->get();
            
        }
        return view('report.index', [
            'orgTypes' => $orgType,
            'goalTopicTags' => $goalTopicTags,
            'presentingChallengeTags' => $presentingChallengeTags,
            'specializedInterventionTags' => $specializedInterventionTags,
            'organizations' => $organizations,
            'programs' => $programs,
        ]);
    }

    public function getTopicPresentingChallengeGraphDetails(Request $request){
    	if(Auth::user()->user_type_id == superAdminUserTypeId()){
    	    $orgTypes = OrganizationType::orderBy('name', 'ASC')->select('*');
        }else{
            $orgTypes =   OrganizationType::whereHas('organizationOrgType',function($query){
                $query->where('organization_id',Auth::user()->organization_id);
            })->orderBy('name', 'ASC')->select('*');

        }

        $si = $request->get('si'); //specialized inventions
        $gt = $request->get('gt'); // goal topic
        $pc = $request->get('pc'); //presenting challenge
        $startDate = $request->get('st_date');
        $endDate = $request->get('en_date');
    	$yaxis = array();
    	$xaxis = [0,0.5,1,1.5,2,2.5,3,3.5,4];
    	$names = array();
		$activity_data = array();

        $orgTypes = $orgTypes->get();

    	foreach($orgTypes as $orgTypeKey => $orgType){
            if(!empty($pc)){
                $presentingChallengeTags = $orgType->presentingChallengeTags->whereIn('id',$pc)->sortBy('tag')->groupBy('group.name')->sortKeys();
            }
            else{
                $presentingChallengeTags = $orgType->presentingChallengeTags->sortBy('tag')->groupBy('group.name')->sortKeys();    
            }

            if(!empty($gt)){
                $goalTopicTags = $orgType->goalTopicTags->whereIn('id',$gt)->sortBy('tag')->groupBy('group.name')->sortKeys();
            }
            else{
                $goalTopicTags = $orgType->goalTopicTags->sortBy('tag')->groupBy('group.name')->sortKeys();
            }

            foreach($presentingChallengeTags as $tagGroup => $tags){
            	foreach($tags as $tagKey => $tag){
                    $data = array();
	            	$i = 0;
	            	foreach($goalTopicTags as $tagGroup1 => $tags1){
                        $data1 = [];
		                foreach($tags1 as $tagKey1 => $tag1){
                            $yaxis[] = $tag1->tag;
		            		$data1[] = calculateTagsAvgCount([$tag->id,$tag1->id],$startDate,$endDate);
		                    $i++;
		                }
                        $d = false;
                        $data['data'] = $data1;
                        $data['color'] = '';
                        $data['name'] = $tag->tag;
                        $activity_data[] = $data;
		            }	        	
                }
            }
        }
       array_multisort(array_column($activity_data, 'name'), SORT_ASC, $activity_data);

        //return view
        return response()->json([
            'status' => 'success',
            'graph_data' => $activity_data,
            'yaxis' => $yaxis,
            'names' => $names,
            'xaxis' => $xaxis
        ]);
	}

    public function getTopicSpecializedInterventionGraphDetails(Request $request){
        $si = $request->get('si');
        $gt = $request->get('gt');
        $pc = $request->get('pc');
        $startDate = $request->get('st_date');
        $endDate = $request->get('en_date');

       if(Auth::user()->user_type_id == superAdminUserTypeId()){
            $orgTypes = OrganizationType::orderBy('name', 'ASC')->select('*')->get();
        }else{
            $orgTypes =   OrganizationType::whereHas('organizationOrgType',function($query){
                $query->where('organization_id',Auth::user()->organization_id);
            })->orderBy('name', 'ASC')->select('*')->get();

        }

        $yaxis = array();
        $xaxis = [0,0.5,1,1.5,2,2.5,3,3.5,4];
        $names = array();
        $activity_data = array();

        foreach($orgTypes as $orgTypeKey => $orgType){
            
            if(isset($si)){
                $specializedInterventionTags = $orgType->specializedInterventionTags->whereIn('id',$si)->sortBy('tag')->groupBy('group.name')->sortKeys();
            }
            else{
                $specializedInterventionTags = $orgType->specializedInterventionTags->sortBy('tag')->groupBy('group.name')->sortKeys();    
               
            }

            if(isset($gt)){
                $goalTopicTags = $orgType->goalTopicTags->whereIn('id',$gt)->sortBy('tag')->groupBy('group.name')->sortKeys();
            }
            else{
                $goalTopicTags = $orgType->goalTopicTags->sortBy('tag')->groupBy('group.name')->sortKeys();
            }

            foreach($specializedInterventionTags as $tagGroup => $tags){
                foreach($tags as $tagKey => $tag){
                    $data = array();
                    $i = 0;
                    foreach($goalTopicTags as $tagGroup1 => $tags1){
                        $data1 = [];
                        foreach($tags1 as $tagKey1 => $tag1){
                            $yaxis[] = $tag1->tag;
                            $data1[] = calculateTagsAvgCount([$tag->id,$tag1->id],$startDate,$endDate);
                            $i++;
                        }
                        $d = false;
                        $data['data'] = $data1;
                        $data['color'] = '';
                        $data['name'] = $tag->tag;
                        $activity_data[] = $data;
                    }               
                }
            }
        }
    array_multisort(array_column($activity_data, 'name'), SORT_ASC, $activity_data);

        //return view
        return response()->json([
            'status' => 'success',
            'graph_data' => $activity_data,
            'yaxis' => $yaxis,
            'names' => $names,
            'xaxis' => $xaxis
        ]);
    }

    public function getPresentingChallengeSpecializedInterventionGraphDetails(Request $request){
        $si = $request->get('si');
        $gt = $request->get('gt');
        $pc = $request->get('pc');
        $startDate = $request->get('st_date');
        $endDate = $request->get('en_date');

        if(Auth::user()->user_type_id == superAdminUserTypeId()){
            $orgTypes = OrganizationType::orderBy('name', 'ASC')->select('*')->get();
        }else{
            $orgTypes =   OrganizationType::whereHas('organizationOrgType',function($query){
                $query->where('organization_id',Auth::user()->organization_id);
            })->orderBy('name', 'ASC')->select('*')->get();

        }
        $yaxis = array();
        $xaxis = [0,0.5,1,1.5,2,2.5,3,3.5,4];
        $names = array();
        $activity_data = array();

        foreach($orgTypes as $orgTypeKey => $orgType){

            if(isset($si)){
                $specializedInterventionTags = $orgType->specializedInterventionTags->whereIn('id',$si)->sortBy('tag')->groupBy('group.name')->sortKeys();
            }
            else{
                $specializedInterventionTags = $orgType->specializedInterventionTags->sortBy('tag')->groupBy('group.name')->sortKeys();    
            }

            if(isset($pc)){
                $presentingChallengeTags = $orgType->presentingChallengeTags->whereIn('id',$pc)->sortBy('tag')->groupBy('group.name')->sortKeys();
            }
            else{
                $presentingChallengeTags = $orgType->presentingChallengeTags->sortBy('tag')->groupBy('group.name')->sortKeys();
            }

            foreach($specializedInterventionTags as $tagGroup => $tags){
                foreach($tags as $tagKey => $tag){
                    $data = array();
                    $i = 0;
                    foreach($presentingChallengeTags as $tagGroup1 => $tags1){
                        $data1 = [];
                        foreach($tags1 as $tagKey1 => $tag1){
                           
                            $yaxis[] = $tag1->tag;
                            $data1[] = calculateTagsAvgCount([$tag->id,$tag1->id],$startDate,$endDate);
                            $i++;
                        }
                        $d = false;
                        $data['data'] = $data1;
                        $data['color'] = '';
                        $data['name'] = $tag->tag;
                        
                    }  
                    $activity_data[] = $data;             
                }
            }
        } 
        array_multisort(array_column($activity_data, 'name'), SORT_ASC, $activity_data);

        //return view
        return response()->json([
            'status' => 'success',
            'graph_data' => $activity_data,
            'yaxis' => $yaxis,
            'names' => $names,
            'xaxis' => $xaxis
        ]);
    }
}