<?php

namespace App\Listeners;

use App\Events\GoalEvents;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use App\Models\LogEvents;
use App\Models\Events;
use Illuminate\Support\Facades\DB;

class GoalImported
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  GoalEvents  $event
     * @return void
     */
    public function handle(GoalEvents $event)
    {
        //print_r($event->request->user()); exit;
        $event_id = $event->request->event_id;
        $user_id = isset($event->request->user()->id)?$event->request->user()->id:'0';
        $user_type_id = isset($event->request->user()->user_type_id)?$event->request->user()->user_type_id:'0';
        $related_id = isset($event->request->related_id)?$event->request->related_id:'0';
        $email = isset($event->request->email)?$event->request->email:'';

        //$eventData = Events::getEventDataByEventId($event_id);
        //$event_type = $eventData->event_type;

        $desc = isset($event->request->desc)?$event->request->desc:'';

        $LogData = array('event_id' => $event_id,
                        'related_id' => $related_id,
                        'email' => $email,
                        'description' => $desc,
                        'user_id' => $user_id,
                        'user_type_id' => $user_type_id,
                        'created_at' => date('Y-m-d H:i:s'),
                        );
        DB::table(with(new LogEvents)->getTable())->insert($LogData);

        //$message = $event->request->user()->name . ' just logged in to the application.';
        Storage::put('testactivity.txt', 'test event called ccccc');
    }
}