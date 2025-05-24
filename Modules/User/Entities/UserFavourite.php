<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Entities\Product;

class UserFavourite extends Model
{
    protected $table = 'users_favourites';
    protected $fillable = [
        'user_id', 'product_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
