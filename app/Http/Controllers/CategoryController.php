<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
class CategoryController extends Controller
{
    protected CategoryService $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index()
    {
        $categories = $this->categoryService->getAll();
        return view('categories.index', compact('categories'));
    }
    public function create()
    {
        return view('categories.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories',
            'description' => 'nullable|string',
        ]);
        $this->categoryService->create($validated);
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);
        $this->categoryService->update($category->id, $validated);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }
    public function destroy(Category $category)
    {
        $this->categoryService->delete($category->id);
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
