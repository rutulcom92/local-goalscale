<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Supervisor\SupervisorRequest;
use App\User;
use App\Models\Goal;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Validator;

class SupervisorGoalController extends Controller
{
    public function list($id,Request $request)
    {
        return Goal::getSupervisorGoalsDt($id,$request);
    }
}