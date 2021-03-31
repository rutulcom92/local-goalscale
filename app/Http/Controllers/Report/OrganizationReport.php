<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\ProviderType;
use DB;
use Auth;

class OrganizationReport extends Controller
{

    public function getAverageGoalChangeByProgram(Request $request){
    	$orgID = $request->get('orgId');
        $pID = $request->get('pId');
        $startDate = $request->get('st_date');
        $endDate = $request->get('en_date');

        if(Auth::user()->user_type_id == superAdminUserTypeId()){
             $programs = Program::select('*');
        }else{
            $programs = Program::whereOrganizationId(Auth::user()->organization_id)->select('*');
        }
        if(!empty($pID)){
            $programs = $programs->whereIn('id',$pID);
        }
        if(!empty($orgID)){
             $programs = $programs->whereIn('organization_id',$orgID);
        }

        $graphData = $this->processProgramGoalsData($programs, $startDate, $endDate);
        $formattedGraphData = $this->formatAverageGoalChangeByProgramData($graphData);

        return response()->json([
            'status' => 'success',
            'categories' => $formattedGraphData->categories,
            'graph_data' => $formattedGraphData->graph_data
        ]);
	}

    private function formatAverageGoalChangeByProgramData($programData) {
        $totalChange = 0;
        $programNames = [];
        foreach ($programData as $key => $value) {
            if ($value->goalsAverageDifference > 0) {
                $totalChange += $value->goalsAverageDifference;
            }
            array_push($programNames, $value->name);
        }

        $programDetails = [];
        for ($x = 0; $x < count($programData); $x++) {
            $currentProgram = $programData[$x];
            if ($currentProgram->goalsAverageDifference > 0) {
                $programDetails[] = (Object) [
                    'name' => $currentProgram->name,
                    'y' => round(($currentProgram->goalsAverageDifference / $totalChange) * 100, 2),
                ];
            }
        }

        return (Object) [
            'categories' => $programNames,
            "graph_data" => $programDetails
        ];
    }

    public function getGoalPerformanceByProgram(Request $request){
        $orgID = $request->get('orgId');
        $pID = $request->get('pId');
        $startDate = $request->get('st_date');
        $endDate = $request->get('en_date');

        if(Auth::user()->user_type_id == superAdminUserTypeId()){
            $programs = Program::select('*');
        }else{
            $programs = Program::whereOrganizationId(Auth::user()->organization_id)->select('*');
        }
        if(!empty($pID)){
            $programs = $programs->whereIn('id',$pID);
        }
        if(!empty($orgID)){
            $programs = $programs->whereIn('organization_id',$orgID);
        }

        $graphData = $this->processProgramGoalsData($programs, $startDate, $endDate);
        $formattedGraphData = $this->formatProgramGoalsAveragesData($graphData);

        return response()->json([
            'status' => 'success',
            'categories' => $formattedGraphData->categories,
            'graph_data' => $formattedGraphData->graph_data
        ]);
    }

    private function processProgramGoalsData($programs, $startDate, $endDate) {
        $programs = $programs->get();
        foreach ($programs as $key => $value) {
            $info = array();
            $info['name'] = $value->name;
            array_push($info, calculateProgramParticipantReportGoals($value->id,$startDate,$endDate));
            $reportData[] = $info;
            $programData[] = $value->name;
        }

        $programsData = [];

        foreach ($reportData as $key => $value) {
            // discard the program if it doesn't contain any goals
            if (count($value[0]) === 0) {
                continue;
            }
            $goals = count($value[0]);
            $goalsValues = array_values($value[0]);
            $goalDifferences = [];
            $currentGoalId = $goalsValues[0]->id;
            $oldestCurrentGoalUpdate = 0;

            // calculate goal difference for each provider in each program
            for ($x = 0; $x < $goals; $x++) {
                if ($x === ($goals - 1)) {
                    $goalDifference = $goalsValues[$x]->activity_ranking - $goalsValues[$oldestCurrentGoalUpdate]->activity_ranking;
                    array_push($goalDifferences, $goalDifference);
                }
                if ($goalsValues[$x]->id !== $currentGoalId) {
                    $goalDifference = $goalsValues[$x - 1]->activity_ranking - $goalsValues[$oldestCurrentGoalUpdate]->activity_ranking;
                    array_push($goalDifferences, $goalDifference);
                    $oldestCurrentGoalUpdate = $x;
                    $currentGoalId = $goalsValues[$x]->id;
                }
            }
            $goalsAverageDifference = 0;
            if (count($goalDifferences)) {
                $goalsAverageDifference = array_sum($goalDifferences) / count($goalDifferences);
            }
            $currentProgram = (Object) [
                'name' => $value['name'],
                'totalGoals' => count($goalDifferences),
                'goalsAverageDifference' => $goalsAverageDifference
            ];
            $programsData[] = $currentProgram;
        }
        return $programsData;
    }

    private function formatProgramGoalsAveragesData($programData) {
        $programNames = array_map(function ($array_item) {
            return $array_item->name;
        }, $programData);

        $programDetails = [];
        for ($x = 0; $x < count($programData); $x++) {
            $currentProgram = $programData[$x];
            $programDetails[] = (Object) [
                'name' => $currentProgram->name,
                'data' => [
                    (Object) [
                        'x' => $x,
                        'y' => round($currentProgram->goalsAverageDifference, 2),
                        'name' => $currentProgram->totalGoals." total goal(s)"
                    ]
                ]
            ];
        }

        return (Object) [
            'categories' => $programNames,
            "graph_data" => $programDetails
        ];
    }

    public function getGoalProgresByProgramAndProviderType(Request $request){
        $orgID = $request->get('orgId');
        $pID = $request->get('pId');
        $startDate = $request->get('st_date');
        $endDate = $request->get('en_date');
        $reportData = array();
        if(Auth::user()->user_type_id == superAdminUserTypeId()){
            $programs = Program::select('*');
        }else{
            $programs = Program::whereOrganizationId(Auth::user()->organization_id)->select('*');
        }
        if(!empty($pID)){
            $programs = $programs->whereIn('id',$pID);
        }
        if(!empty($orgID)){
            $programs = $programs->whereIn('organization_id',$orgID);
        }

        $programs = $programs->get();
        foreach ($programs as $key => $value) {
            $info = array();
            $info['name'] = $value->name;
            $info['goals'] = calculateGoalProgressProgramProviderTypeAvgCount($value->id,$startDate,$endDate);
            $reportData[] = $info;
        }

        return response()->json([
            'status' => 'success',
            'graph_data' => ['data' => $reportData]
        ]);
    }

}
