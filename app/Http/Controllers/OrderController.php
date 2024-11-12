<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Services\OrderService;
use App\Support\StatusCode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function store(OrderStoreRequest $request)
    {
        try {
            
            DB::beginTransaction();

            $order = (new OrderService())->createOrder($request->all());

            DB::commit();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully',
                'data' => $order,
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('File:'.$e->getFile().' Line:'.$e->getLine().' Message:'.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], StatusCode::INTERNAL_SERVER_ERROR);
        }
    }

    public function history(Request $request)
    {
        $orders = Order::with('orderItems.product')->where('user_id', auth()->user()->id)->paginate($request->limit ?? 10);

        return response()->json([
            'status' => 'success',
            'data' => $orders,
        ], StatusCode::SUCCESS);
    }
}
