<?php 

namespace App\Listeners;

class GoalEventListener { 

    /**
     * Handle user login events. 
     */ 
    public function importGoal($event) {}

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event) {}

    public function subscribe($events)
    {
        $events->listen(
            'App\Events\GoalEvents',
            'App\Listeners\GoalEventListener@importGoal'
        );

        $events->listen(
            'App\Events\UserLoggedOut',
            'App\Listeners\GoalEventListener@onUserLogout'
        );
    }
}