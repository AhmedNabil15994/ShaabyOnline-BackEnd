<?php

namespace Modules\Catalog\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Catalog\Mail\Dashboard\CheckProductQtyMail;
use Modules\Vendor\Repositories\Dashboard\VendorRepository as Vendor;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CheckProductQty extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'product:checkQty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a daily email to admins and vendors with a list of low products quantities.';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $vendor;

    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $minQty = config('setting.products.minimum_products_qty') ?? 0;
        $vendors = $this->vendor->getActiveVendorsWithLimitProducts($minQty);

        if (count($vendors) > 0) {
            foreach ($vendors as $k => $vendor) {
                if (count($vendor->products) > 0) {
                    // Send E-mail To Admins & Vendors
                    $to = [];

                    // Vendor E-mail
                    if ($vendor->vendor_email)
                        $to[] = $vendor->vendor_email;

                    // Admin E-mail
                    if (config('setting.contact_us.email'))
                        $to[] = config('setting.contact_us.email');

                    Mail::to($to)
                        ->send(new CheckProductQtyMail($vendor->products));
                }
            }
        }

        $this->info('E-mails Sent Successfully!');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    /*protected function getArguments()
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }*/

    /**
     * Get the console command options.
     *
     * @return array
     */
    /*protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }*/
}
