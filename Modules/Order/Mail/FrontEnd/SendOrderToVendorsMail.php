<?php

namespace Modules\Order\Mail\FrontEnd;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class SendOrderToVendorsMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $extraData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $extraData = [])
    {
        $this->order = $order;
        $this->extraData = $extraData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = $this->order;
        $extraData = $this->extraData;
        $emailTitle = 'New order # ' . $order->id;
        $emailLogo = config('setting.images.logo') ? asset(config('setting.images.logo')) : asset('frontend/images/email-logo.svg');

        return $this->subject($emailTitle)->view('order::frontend.emails.vendors', compact('order', 'extraData', 'emailLogo'));
    }
}
