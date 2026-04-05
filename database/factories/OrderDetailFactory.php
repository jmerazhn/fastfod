<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Product;

class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        /*
        $order = Order::doesnthave('details')->get()->first();

        return  [
            'order_id' => $order->id,
            'product_id' => Product::all()->random(),
            'quantity' => $order->items,
            'price' => $order->total / $order->items,
        ];
        */
    }
}
