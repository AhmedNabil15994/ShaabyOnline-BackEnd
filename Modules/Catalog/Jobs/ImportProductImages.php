<?php

namespace Modules\Catalog\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Catalog\Repositories\Dashboard\ProductRepository as Product;

class ImportProductImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $request;
    private $product;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
        $this->product = new Product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->product->importPhotos($this->request);
    }
}
