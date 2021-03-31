<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Goal;
use App\Models\ProgramOrgAdmin;
use App\Models\ProgramSupervisor;

class CheckForOrgAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(Auth::user()->user_type_id == 5){
                //

            if($request->route()->getName() == 'supervisor.edit'){
                $supervisor_id = $request->route()->parameter('supervisor');

                $orgAdminAccess = User::whereId($supervisor_id)->whereUserTypeId(supervisorUserTypeId())->whereOrganizationId(Auth::user()->organization_id)->first();

                if(empty($orgAdminAccess)){
                    Auth::logout();
                    return redirect(route("login"));

                }
            }else if($request->route()->getName() == 'provider.edit'){

                $provider_id = $request->route()->parameter('provider');

                $orgAdminAccess = User::whereId($provider_id)->whereUserTypeId(providerUserTypeId())->whereOrganizationId(Auth::user()->organization_id)->first();

                 if(empty($orgAdminAccess)){

                    Auth::logout();
                    return redirect(route("login"));

                }
            }else if($request->route()->getName() == 'participant.edit'){

                $participant_id = $request->route()->parameter('participant');

                $orgAdminAccess = User::whereId($participant_id)->whereUserTypeId(participantUserTypeId())->whereOrganizationId(Auth::user()->organization_id)->first();

                 if(empty($orgAdminAccess)){

                   Auth::logout();
                    return redirect(route("login"));

                }
            }
            else if($request->route()->getName() == 'goal.edit'){

                $goal_id = $request->route()->parameter('goal');

                 $AdminAccess = Goal::whereHas('provider',function($query){
                        $query->whereHas('providerSupervisor',function($query1){
                            $query1->whereHas('supervisor',function($query2){
                             $query2->whereHas('organization',function($query3){
                                $query3->where('id',Auth::user()->organization_id);
                         });
                      });
                    });
                })->whereId($goal_id)->get()->first();
                
                if(empty($AdminAccess)){

                   Auth::logout();
                    return redirect(route("login"));

                }
            }
            else if($request->route()->getName() == 'program.edit'){

                $program_id = $request->route()->parameter('program');

                $orgAdminAccess = ProgramOrgAdmin::whereProgramId($program_id)->whereAdminId(Auth::user()->id)->first();
              
                 if(empty($orgAdminAccess)){

                    Auth::logout();
                    return redirect(route("login"));

                }
            }else{
                return $next($request);
            }
        }else if(Auth::user()->user_type_id == 4){
             if($request->route()->getName() == 'goal.edit'){
                $goal_id = $request->route()->parameter('goal');
                $AdminAccess = Goal::whereId($goal_id)->whereParticipantId(Auth::user()->id)->first();
              
                 if(empty($AdminAccess)){

                    Auth::logout();
                    return redirect(route("login"));

                }
             }
        }else if(Auth::user()->user_type_id == 3){
             if($request->route()->getName() == 'participant.edit'){
                $user_id = Auth::user()->id;
                $participant_id = $request->route()->parameter('participant');
                $AdminAccess = User::whereHas('participantProvider',function($query) use($user_id) {
                    $query->where('provider_id',$user_id);   
                })->whereUserTypeId(participantUserTypeId())->whereId($participant_id)->first();
              
                if(empty($AdminAccess)){

                    Auth::logout();
                    return redirect(route("login"));
                }
             }else if($request->route()->getName() == 'goal.edit'){
                $goal_id = $request->route()->parameter('goal');
                $AdminAccess = Goal::whereId($goal_id)->whereProviderId(Auth::user()->id)->first();
              
                 if(empty($AdminAccess)){

                    Auth::logout();
                    return redirect(route("login"));
                }
            }else{
                return $next($request);
            }
        }else if(Auth::user()->user_type_id == 2){
            if($request->route()->getName() == 'program.edit'){

                $program_id = $request->route()->parameter('program');

                $AdminAccess = ProgramSupervisor::whereProgramId($program_id)->whereSupervisorId(Auth::user()->id)->first();
             
                if(empty($AdminAccess)){

                    Auth::logout();
                    return redirect(route("login"));
                }
            }else if($request->route()->getName() == 'provider.edit'){

                $provider_id = $request->route()->parameter('provider');
                $user_id = Auth::user()->id;
                $AdminAccess = User::whereHas('providerSupervisor',function($query) use($user_id) {
                    $query->where('supervisor_id',$user_id);   
                })->whereUserTypeId(providerUserTypeId())->whereId($provider_id)->first();
              
              
                if(empty($AdminAccess)){

                    Auth::logout();
                    return redirect(route("login"));
                }
            }else if($request->route()->getName() == 'participant.edit'){

                $participant_id = $request->route()->parameter('participant');

                $AdminAccess = User::whereHas('participantProvider',function($query){
                        $query->whereHas('provider',function($query1){
                             $query1->whereHas('providerSupervisor',function($query2){
                                $query2->where('supervisor_id',Auth::user()->id);
                         });
                      });
                    })->whereId($participant_id)->get()->first();
             
                if(empty($AdminAccess)){

                    Auth::logout();
                    return redirect(route("login"));
                }
            }else if($request->route()->getName() == 'goal.edit'){

                $goal_id = $request->route()->parameter('goal');
                $AdminAccess = Goal::whereHas('provider',function($query) {
                $query->whereHas('providerSupervisor',function($query){
                         $query->where('supervisor_id',Auth::user()->id);
                    });
                })->whereId($goal_id)->get()->first();
              
                 if(empty($AdminAccess)){

                    Auth::logout();
                    return redirect(route("login"));
                }
            }else{
                 return $next($request);
            }
        }

       return $next($request);
    }
}

?>