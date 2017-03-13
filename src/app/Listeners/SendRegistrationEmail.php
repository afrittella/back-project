<?php

namespace Afrittella\BackProject\Listeners;

use Afrittella\BackProject\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Afrittella\BackProject\Repositories\Users;

use Illuminate\Support\Facades\Log;
use Afrittella\BackProject\Notifications\RegistrationEmail;

class SendRegistrationEmail implements ShouldQueue
{
    protected $users;
    /**
     * Create the event listener.
     *
     */
    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    /**
     * Handle the event.
     *
     * @param  vent=UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
      //try {
        $user = $this->users->findBy('id', $event->user_id);
        $user->notify(new RegistrationEmail($user));
      //} catch(\Exception $e) {
        //Log::error('lavoro fallito');
      //}

    }

    public function failed(UserRegistered $event, $exception)
    {
        Log::error('fallito ');
    }
}
