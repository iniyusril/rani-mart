<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public function index()
    {
        $sql = <<<SQL
        select p.product_name, sum(qty) sale_product from products p
        inner join order_details od
        on od.product_id  = p.id
        inner join orders o
        on o.id  = od.order_id
        GROUP  by p.id
        order by sale_product desc
        SQL;

        $data = DB::select($sql);
        return view('menu.result.index', compact('data'));
    }
}