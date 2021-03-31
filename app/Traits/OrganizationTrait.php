<?php

namespace App\Traits;

trait OrganizationTrait
{
    public function addUser()
    {
        return $this->update(['num_users' => $this->num_users + 1 ]);
    }

    public function removeUser()
    {
        return  $this->update(['num_users' => $this->num_users - 1 ]);
    }

    public function addProvider()
    {
        return $this->update(['num_providers' => $this->num_providers + 1 ]);
    }

    public function removeProvider()
    {
        return  $this->update(['num_providers' => $this->num_providers - 1 ]);
    }    

    public function addGoal()
    {
        return $this->update(['num_goals' => $this->num_goals + 1 ]);
    }

    public function removeGoal()
    {
        return  $this->update(['num_goals' => $this->num_goals - 1 ]);
    }

    public function setAvgGoal($avg_goal_change){
        return  $this->update(['avg_goal_change' => $avg_goal_change ]);   
    }
    
    public function setGoalCount($count){
        return  $this->update(['num_goals' => $count ]);   
    }

    public function setUserCount($count){
        return  $this->update(['num_users' => $count ]);   
    }

    public function setProviderCount($count){
        return  $this->update(['num_providers' => $count ]);      
    }
}