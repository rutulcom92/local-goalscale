<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Provider\ProviderRequest;
use App\User;
use App\Models\State;
use App\Models\UserDetail;
use App\Models\Organization;
use App\Models\Program;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Validator;

class ProviderParticipantController extends Controller
{
    public function list($id,Request $request)
    {
        return User::getProviderParticipantDt($id,$request);
    }
}