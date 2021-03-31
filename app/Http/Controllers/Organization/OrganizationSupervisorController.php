<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Organization;
use App\Models\Program;
use App\User;
use App\Http\Requests\Organization\OrganizationRequest;
use Validator;

class OrganizationSupervisorController extends Controller
{
    public function list($id,Request $request)
    {
        return User::getOrganizationSupervisorDt($id,$request);
    }
}