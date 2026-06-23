<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
class ProductApiController extends Controller
{
    public function index()
    {
        return response()->json(Product::with('category')->paginate(20));
    }
    public function show($id)
    {
        return response()->json(Product::with('category')->findOrFail($id));
    }
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $products = Product::where('product_name', 'like', "%{$query}%")
            ->orWhere('product_code', 'like', "%{$query}%")
            ->orWhere('barcode', 'like', "%{$query}%")
            ->paginate(20);
        return response()->json($products);
    }
}
