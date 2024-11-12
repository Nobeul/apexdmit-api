<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\StatusCode;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $paginate = $request->paginate ?? false;

        $products = User::findByFilters($request->all(), $paginate, $limit);

        return response()->json([
            'status' => 'success',
            'data' => $products,
        ], StatusCode::SUCCESS);
    }
}
