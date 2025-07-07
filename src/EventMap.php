<?php

namespace GSManager\AuthenticationLog;

trait EventMap
{
    /**
     * The Authentication Log event / listener mappings.
     *
     * @var array
     */
    protected $events = [
        'GSManager\Auth\Events\Login' => [
            'GSManager\AuthenticationLog\Listeners\LogSuccessfulLogin',
        ],

        'GSManager\Auth\Events\Logout' => [
            'GSManager\AuthenticationLog\Listeners\LogSuccessfulLogout',
        ],
    ];
}
