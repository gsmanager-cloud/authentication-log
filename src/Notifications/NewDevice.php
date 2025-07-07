<?php

namespace GSManager\AuthenticationLog\Notifications;

use GSManager\Bus\Queueable;
use GSManager\Contracts\Queue\ShouldQueue;
use GSManager\Notifications\Messages\MailMessage;
use GSManager\Notifications\Notification;
use GSManager\AuthenticationLog\AuthenticationLog;

class NewDevice extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The authentication log.
     *
     * @var \GSManager\AuthenticationLog\AuthenticationLog
     */
    public $authenticationLog;

    /**
     * Create a new notification instance.
     *
     * @param  \GSManager\AuthenticationLog\AuthenticationLog  $authenticationLog
     * @return void
     */
    public function __construct(AuthenticationLog $authenticationLog)
    {
        $this->authenticationLog = $authenticationLog;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->notifyAuthenticationLogVia();
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \GSManager\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(trans('authentication-log::messages.subject'))
            ->markdown('authentication-log::emails.new', [
                'account' => $notifiable,
                'time' => $this->authenticationLog->login_at,
                'ipAddress' => $this->authenticationLog->ip_address,
                'browser' => $this->authenticationLog->user_agent,
            ]);
    }
}
