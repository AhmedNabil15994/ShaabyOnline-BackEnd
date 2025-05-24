<?php

namespace Modules\Vendor\Notifications\FrontEnd;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PrescriptionVendordNotification extends Notification
{
    use Queueable;

    public $data = [];

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;

        /*if (isset($data['image']) && !empty($data['image']))
            $this->data['image'] = 'data:image/png;base64, ' . base64_encode(file_get_contents($data['image'])); // convert image file to base64
        else
            $this->data['image'] = null;*/
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
        return (new MailMessage)
            ->subject(__('vendor::frontend.vendors.prescription_r.mail.subject'))
            ->markdown('vendor::frontend.emails.prescription', ['data' => $this->data]);
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
