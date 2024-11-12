<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Support\StatusCode;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $paginate = $request->paginate ?? false;

        $products = Product::findByFilters($request->all(), ['orderItems'], $paginate, $limit);

        return response()->json([
            'status' => 'success',
            'data' => $products,
        ], StatusCode::SUCCESS);
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        return response()->json($product, 201);
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::findByFilters(['id' => $id], [], first: true);
        
        if (empty($product)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Did not find the product',
            ], StatusCode::NOT_FOUND);
        }

        $product->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Product info has been updated successfully.',
            'data' => $product,
        ], StatusCode::SUCCESS);
    }

    public function destroy($id)
    {
        $product = Product::findByFilters(['id' => $id], ['orderItems'], first: true);

        if (empty($product)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Did not find the product',
            ], StatusCode::NOT_FOUND);
        }

        if (count($product->orderItems) > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'This product can not be deleted. This product has orders',
            ], StatusCode::CONFLICT);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'The product has been deleted successfully.',
        ], StatusCode::SUCCESS);
    }
}
