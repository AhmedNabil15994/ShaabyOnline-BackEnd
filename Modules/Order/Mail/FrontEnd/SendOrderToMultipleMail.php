<?php

namespace Modules\Order\Mail\FrontEnd;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class SendOrderToMultipleMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $flag;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $flag = 'user_email')
    {
        $this->order = $order;
        $this->flag = $flag;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = $this->order;
        $emailTitle = 'New order # ' . $order->id;
        $emailLogo = config('setting.images.logo') ? asset(config('setting.images.logo')) : asset('frontend/images/email-logo.svg');

        if ($this->flag == 'user_email') {
            return $this->subject($emailTitle)->view('order::frontend.emails.user', compact('order', 'emailLogo'));
        } elseif ($this->flag == 'admin_email') {
            return $this->subject($emailTitle)->view('order::frontend.emails.admins', compact('order', 'emailLogo'));
        } else {
            return '';
        }
    }
}
