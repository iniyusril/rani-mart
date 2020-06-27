<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['product_name', 'price', 'stock', 'category_id'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function orders()
    {
        return $this->belongsToMany('App\Order', 'order_details', 'product_id', 'order_id');
    }
}