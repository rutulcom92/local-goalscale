<?php 
namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Organization;
use App\Models\Program;
use App\User;
use App\Http\Requests\Program\ProgramRequest;
use Validator;

class ProgramProviderController extends Controller
{
    public function list($id,Request $request)
    {
        return Program::getProgramProviderDt($id,$request);
    }
}

?>