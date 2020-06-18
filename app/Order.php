<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_date'];
    public function order_details(){
        $this->hasMany('App\OrderDetails');
    }
}
