<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Goal;
use App\User;

class OrganizationGoalController extends Controller
{
    public function list($id,Request $request)
    {
        return Goal::getOrganizationGoalDt($id,$request);
    }
}