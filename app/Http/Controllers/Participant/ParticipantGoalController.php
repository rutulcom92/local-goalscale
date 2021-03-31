<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Goal;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Validator;

class ParticipantGoalController extends Controller
{
    public function list($id,Request $request)
    {
        return Goal::getParticipantGoalDt($id,$request);
    }
}