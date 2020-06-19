<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetails;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('menu.order.index');
    }
    public function search($query)
    {
        $datas = Product::select('id', 'product_name', 'price')
            ->where('product_name', 'like', '%' . $query . '%')->get();
        return response()->json($datas, 200);
    }
    public function store(Request $request)
    {
        $date = Carbon::now();
        $order = Order::create([
            'order_date' => $date,
        ]);

        $data_order = $request->json()->all();
        foreach ($data_order as $item) {
            $data = new OrderDetails();
            $data->price = $item['price'];
            $data->qty = $item['qty'];
            $data->order_id = $order->id;
            $data->product_id = $item['id'];
            $data->save();
        }

        return response()->json(true, 200);
    }
}