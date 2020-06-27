<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_date'];

    public function products()
    {
        return $this->belongsToMany('App\Product', 'order_details', 'order_id', 'product_id');
    }
}