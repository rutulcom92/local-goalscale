<?php

namespace App\Http\Controllers\Events;

use Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogEvents;
use App\Models\UserType;
use App\Models\Events;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //if(Auth::user()->user_type_id == superAdminUserTypeId()){
            $userTypes = UserType::orderBy('name', 'ASC')->get();

            $eventTypes = DB::table('events')
                            ->select('event_type', DB::raw('count(*) as total'))
                            ->groupBy('event_type')
                            ->pluck('event_type')
                            ->all();

            $eventNames = DB::table('events')->select('event_name')->pluck('event_name')->all();

            //echo 'eventTypes = <pre>';print_r($eventNames);echo '</pre>'; exit;

            return view('event.index')->with([
                'userTypes' => $userTypes,
                'eventNames' => (object) $eventNames,
                'eventTypes' => (object) $eventTypes,
            ]);
            return view('event.index');//, compact('logevents'));
        //}
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {

            $eventFilters = [];

            if (Auth::user()->isSuperAdmin()) {
                $eventFilters['userTypesIdArray'] = (!empty($request->userType) ? [$request->userType] : []);

                if (!empty($request->eventType)) {
                    $EventIds = DB::table(with(new Events)->getTable())->select('event_id')->where('event_type', $request->eventType)->pluck('event_id')->all();
                    $eventFilters['eventIdsArray'] = $EventIds;
                }

                if (!empty($request->eventName)) {
                    $EventNameIds = DB::table(with(new Events)->getTable())->select('event_id')->where('event_name', $request->eventName)->pluck('event_id')->all();
                    $eventFilters['eventNameIdsArray'] = $EventNameIds;
                }
            }
            //echo '<br>id = <pre>';print_r($eventFilters);echo '</pre>'; exit;
            $eventFilters['userType'] = $request->userType;
            $eventFilters['eventType'] = $request->eventType;
            $eventFilters['eventName'] = $request->eventName;
            $eventFilters['event_from_date'] = $request->event_from_date;
            $eventFilters['event_to_date'] = $request->event_to_date;

            //goal_activity.created_at >= '".DBDateFormat($start_date)."'

            return LogEvents::getEventsDt($eventFilters);

        } else {
            abort(500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
