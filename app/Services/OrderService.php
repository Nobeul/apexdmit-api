<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder(array $request)
    {
        DB::beginTransaction();

        try {

            $order = $this->createOrderEntry();

            [$orderItems, $totalAmount] = $this->processOrderItems($request['products'], $order);
            
            $this->insertOrderItems($orderItems);

            $this->updateOrderTotalAmount($order, $totalAmount);

            DB::commit();

            return $order->load('orderItems.product');

        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    protected function createOrderEntry()
    {
        return Order::create([
            'user_id' => auth()->user()->id,
            'total_amount' => 0,
        ]);
    }

    protected function processOrderItems(array $items, Order $order)
    {
        $totalAmount = 0;
        $orderItems = [];

        $productIds = collect($items)->pluck('product_id');
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($items as $item) {
            $product = $products->get($item['product_id']);

            if (!$product) {
                throw new Exception("Product not found: ID " . $item['product_id']);
            }

            if ($product->stock < $item['quantity']) {
                throw new Exception("Insufficient stock for product " . $product->name);
            }

            $totalAmount += $product->price * $item['quantity'];

            $product->decrement('stock', $item['quantity']);

            $orderItems[] = [
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price * $item['quantity'],
            ];
        }

        return [$orderItems, $totalAmount];
    }

    protected function insertOrderItems(array $orderItems)
    {
        OrderItem::insert($orderItems);
    }

    protected function updateOrderTotalAmount(Order $order, $totalAmount)
    {
        $order->update(['total_amount' => $totalAmount]);
    }
}
