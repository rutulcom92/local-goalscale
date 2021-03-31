<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Organization;
use App\Models\Program;
use App\User;
use Validator;

class OrganizationProgramController extends Controller
{
    public function list($id,Request $request)
    {
        return Program::getOrganizationProgramsDt($id,$request);
    }
}