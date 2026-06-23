<?php
namespace App\Http\Controllers;
use App\Models\Supplier;
use App\Services\SupplierService;
use Illuminate\Http\Request;
class SupplierController extends Controller
{
    protected SupplierService $supplierService;
    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }
    public function index()
    {
        $suppliers = $this->supplierService->getAllPaginated(15);
        return view('suppliers.index', compact('suppliers'));
    }
    public function create()
    {
        return view('suppliers.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:200',
            'contact_person' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);
        $this->supplierService->create($validated);
        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }
    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:200',
            'contact_person' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);
        $this->supplierService->update($supplier->id, $validated);
        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }
    public function destroy(Supplier $supplier)
    {
        $this->supplierService->delete($supplier->id);
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}
