<?php

namespace Modules\Authentication\Notifications\FrontEnd;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    protected $token;
    protected $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $type = 'frontend')
    {
        $this->token = $token;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = $this->type == 'dashboard' ?  'dashboard' : 'frontend';
        $customUrl = url(route($url . '.password.reset', $this->token['token']) . '?email=' . $this->token['user']->email);
        return (new MailMessage)
            ->subject(__('authentication::frontend.reset.mail.subject'))
            ->markdown('authentication::frontend.emails.reset', ['customUrl' => $customUrl]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
