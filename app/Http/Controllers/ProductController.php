<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function searchProduct(Request $request)
    {
        $query = $request->query('q');
        $products = Product::where('nazwa_produktu', 'like', '%' . $query . '%')
            ->orWhere('producent', 'like', '%' . $query . '%')
            ->get();

        return response()->json($products);
    }
}
