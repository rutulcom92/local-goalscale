<?php

namespace App\Traits;
use App\User;

trait GoalTrait
{
	public function addParticipantGoal(){
        return $this->participant()->first()->userDetail->addGoal();
    }

    public function addProviderGoal(){
    	return $this->provider()->first()->userDetail->addGoal();
    }

    public function addSupervisorGoal(){
        $supervisor = $this->provider()->first()->providerSupervisor()->first()->supervisor()->first();
        if(!empty($supervisor->userDetail)){
        	return $supervisor->userDetail->addGoal();
        }
        else{
            $supr_detail = $supervisor->userDetail()->create([
                'user_id' => $supervisor->id
            ]);
            return $supr_detail->addGoal();
        }
    }

    public function addOrganizationGoal(){
    	return $this->participant()->first()->organization->addGoal();
    }

    public function setParticipantGoalCount(){
        return $this->participant()->first()->userDetail->setGoalCount($this->calculateParticipantGoalCount($this->participant_id));
    }

    public function setProviderGoalCount(){
        return  $this->provider()->first()->userDetail->setGoalCount($this->calculateProviderGoalCount($this->provider_id));
    }

    public function setSupervisorGoalCount(){
        $supervisor_id = $this->provider()->first()->providerSupervisor()->first()->supervisor_id; 
        $provider_ids = User::select('id')->whereUserTypeId('3')->whereHas('providerSupervisor',function($query) use ($supervisor_id){
            $query->whereSupervisorId($supervisor_id);
        })->get()->pluck('id')->toArray();
        return  User::find($supervisor_id)->userDetail->setGoalCount($this->calculateSupervisorGoalCount($provider_ids));
    }

    public function setOrganizationGoalCount(){
        $provider_ids = User::select('id')->whereUserTypeId('3')->whereOrganizationId($this->participant()->first()->organization_id)->get()->pluck('id')->toArray();
        $this->participant()->first()->organization->setGoalCount($this->calculateSupervisorGoalCount($provider_ids));
    }

    public function calculateParticipantGoalCount($participant_id){
        return (Self::whereParticipantId($participant_id)->whereStatusId(goalActiveStatusId())->count());
    }

    public function calculateProviderGoalCount($provider_id){
        return (Self::whereProviderId($provider_id)->whereStatusId(goalActiveStatusId())->count());
    }

    public function calculateSupervisorGoalCount($provider_ids){
        return (Self::whereIn('provider_id',$provider_ids)->whereStatusId(goalActiveStatusId())->count());
    }

    public function setParticipantAvgGoal(){
    	return $this->participant()->first()->userDetail->setAvgGoal($this->calculateParticipantAvgGoal($this->participant_id));
    }

    public function setProviderAvgGoal(){
    	return	$this->provider()->first()->userDetail->setAvgGoal($this->calculateProviderAvgGoal($this->provider_id));
    }

    public function setSupervisorAvgGoal(){
    	$supervisor_id = $this->provider()->first()->providerSupervisor()->first()->supervisor_id; 
        $provider_ids = User::select('id')->whereUserTypeId('3')->whereHas('providerSupervisor',function($query) use ($supervisor_id){
            $query->whereSupervisorId($supervisor_id);
        })->get()->pluck('id')->toArray();
        return  User::find($supervisor_id)->userDetail->setAvgGoal($this->calculateSupervisorAvgGoal($provider_ids));
    }

    public function setOrganizationAvgGoal(){
    	$provider_ids = User::select('id')->whereUserTypeId('3')->whereOrganizationId($this->participant()->first()->organization_id)->get()->pluck('id')->toArray();
        return $this->participant()->first()->organization->setAvgGoal($this->calculateSupervisorAvgGoal($provider_ids));
    }

    public function calculateParticipantAvgGoal($participant_id){
        if(calculateNumOfParticipantsOpenGoals($participant_id) == 0){
            return 0;
        }
        return (calculateSumOfParticipantsLatestActivity($participant_id) / calculateNumOfParticipantsOpenGoals($participant_id));
    }

    public function calculateProviderAvgGoal($provider_id){
        if(calculateNumOfProviderOpenGoals($provider_id) == 0){
            return 0;
        }
        return (calculateSumOfProviderLatestActivity($provider_id) / calculateNumOfProviderOpenGoals($provider_id));
    }

    public function calculateSupervisorAvgGoal($provider_ids){
        if(calculateNumOfSupervisorOpenGoals($provider_ids) == 0){
            return 0;
        }
        return (calculateSumOfSupervisorLatestActivity($provider_ids) / calculateNumOfSupervisorOpenGoals($provider_ids));
    }
}