<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

use Spatie\Translatable\HasTranslations;

class OrderStatus extends Model
{
    use HasTranslations, ScopesTrait;

    protected $with = [];
    protected $guarded = ["id"];
    public $translatable = ['title'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function orderStatusesHistory()
    {
        return $this->belongsToMany(Order::class, 'order_statuses_history')->withPivot(['user_id'])->withTimestamps();
    }
}
