<?php

namespace Modules\Order\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Order\Mail\FrontEnd\SendOrderToMultipleMail;
use Illuminate\Support\Facades\Mail;

class SendOrderToMultipleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $emails;
    protected $flag;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order, $emails = [], $flag = 'user_email')
    {
        $this->order = $order;
        $this->emails = $emails;
        $this->flag = $flag;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emailTemplate = new SendOrderToMultipleMail($this->order, $this->flag);
        return Mail::to($this->emails)->send($emailTemplate);
    }
}
