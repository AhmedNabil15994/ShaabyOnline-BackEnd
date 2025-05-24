<?php

namespace Modules\Transaction\Entities;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
      'auth',
      'method' ,
      'tran_id' ,
      'result' ,
      'post_date' ,
      'ref' ,
      'track_id' ,
      'payment_id' ,
      'transaction_type' ,
      'transaction_id',
    ];

    public function transaction()
    {
        return $this->morphTo();
    }
}
