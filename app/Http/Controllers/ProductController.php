<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Services\ProductService;
use App\Models\Category;
use Illuminate\Http\Request;
class ProductController extends Controller
{
    protected ProductService $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index(Request $request)
    {
        $query = $request->get('search');
        $products = $query
            ? $this->productService->search($query)
            : $this->productService->getAllPaginated(15);
        $categories = Category::active()->get();
        return view('products.index', compact('products', 'categories', 'query'));
    }
    public function create()
    {
        $categories = Category::active()->get();
        return view('products.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_code' => 'required|string|max:50|unique:products',
            'product_name' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'reorder_level' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'barcode' => 'nullable|string|max:100|unique:products',
        ]);
        $this->productService->create($validated);
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        return view('products.edit', compact('product', 'categories'));
    }
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_code' => 'required|string|max:50|unique:products,product_code,' . $product->id,
            'product_name' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'reorder_level' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'barcode' => 'nullable|string|max:100|unique:products,barcode,' . $product->id,
        ]);
        $this->productService->update($product->id, $validated);
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }
    public function destroy(Product $product)
    {
        $this->productService->delete($product->id);
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
