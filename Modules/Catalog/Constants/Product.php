<?php

namespace Modules\Catalog\Constants;

class Product
{
    const SINGLE_PRODUCT_COLS_NEEDS = ['id','image','title','slug','price','is_new'];
    const IMPORT_PRODUCT_COLS  = [
        'category',
        'title_ar',
        'title_en',
        'sku',
        'price',
        'offer_price',
        'offer_start_at',
        'offer_end_at',
        'description_ar',
        'description_en',
        'qty',
        'status'
    ];
}
