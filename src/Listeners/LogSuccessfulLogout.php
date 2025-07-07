<?php

namespace GSManager\AuthenticationLog\Listeners;

use GSManager\Auth\Events\Logout;
use GSManager\Http\Request;
use GSManager\Support\Carbon;
use GSManager\AuthenticationLog\AuthenticationLog;

class LogSuccessfulLogout
{
    /**
     * The request.
     *
     * @var \GSManager\Http\Request
     */
    public $request;

    /**
     * Create the event listener.
     *
     * @param  \GSManager\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        if ($event->user) {
            $user = $event->user;
            $ip = $this->request->ip();
            $userAgent = $this->request->userAgent();
            $authenticationLog = $user->authentications()->whereIpAddress($ip)->whereUserAgent($userAgent)->first();

            if (! $authenticationLog) {
                $authenticationLog = new AuthenticationLog([
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                ]);
            }

            $authenticationLog->logout_at = Carbon::now();

            $user->authentications()->save($authenticationLog);
        }
    }
}
