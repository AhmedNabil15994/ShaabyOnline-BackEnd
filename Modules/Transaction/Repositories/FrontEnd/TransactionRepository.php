<?php

namespace Modules\Transaction\Repositories\FrontEnd;

use Modules\Transaction\Entities\Transaction;
use Hash;
use DB;

class TransactionRepository
{

    function __construct(Transaction $transaction)
    {
        $this->transaction   = $transaction;
    }

}
