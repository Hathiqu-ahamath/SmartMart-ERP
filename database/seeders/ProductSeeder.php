<?php
namespace Database\Seeders;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Dairy', 'slug' => 'dairy', 'description' => 'Milk, cheese, yogurt products'],
            ['name' => 'Beverages', 'slug' => 'beverages', 'description' => 'Soft drinks, juices, water'],
            ['name' => 'Snacks', 'slug' => 'snacks', 'description' => 'Chips, biscuits, confectionery'],
            ['name' => 'Vegetables', 'slug' => 'vegetables', 'description' => 'Fresh vegetables and herbs'],
            ['name' => 'Household', 'slug' => 'household', 'description' => 'Cleaning and household items'],
            ['name' => 'Bakery', 'slug' => 'bakery', 'description' => 'Bread, cakes, pastries'],
            ['name' => 'Meat', 'slug' => 'meat', 'description' => 'Fresh and frozen meat'],
        ];
        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        $supplier = Supplier::firstOrCreate(
            ['email' => 'supplier@example.com'],
            [
                'company_name' => 'Prime Distributors',
                'supplier_code' => 'SUP-001',
                'contact_person' => 'John Doe',
                'phone' => '0112345678',
                'address' => '123 Main Street, Colombo',
            ]
        );

        $categoryIds = Category::pluck('id', 'slug');

        $productsData = [
            ['product_name' => 'Fresh Milk 1L', 'product_code' => 'DRY-001', 'category_slug' => 'dairy', 'cost_price' => 180, 'selling_price' => 220, 'stock_quantity' => 50, 'min_stock' => 10],
            ['product_name' => 'Cheddar Cheese 200g', 'product_code' => 'DRY-002', 'category_slug' => 'dairy', 'cost_price' => 450, 'selling_price' => 550, 'stock_quantity' => 30, 'min_stock' => 5],
            ['product_name' => 'Coca Cola 1.5L', 'product_code' => 'BEV-001', 'category_slug' => 'beverages', 'cost_price' => 150, 'selling_price' => 190, 'stock_quantity' => 100, 'min_stock' => 20],
            ['product_name' => 'Orange Juice 1L', 'product_code' => 'BEV-002', 'category_slug' => 'beverages', 'cost_price' => 250, 'selling_price' => 320, 'stock_quantity' => 40, 'min_stock' => 10],
            ['product_name' => 'Potato Chips 50g', 'product_code' => 'SNK-001', 'category_slug' => 'snacks', 'cost_price' => 80, 'selling_price' => 120, 'stock_quantity' => 200, 'min_stock' => 30],
            ['product_name' => 'Chocolate Bar', 'product_code' => 'SNK-002', 'category_slug' => 'snacks', 'cost_price' => 120, 'selling_price' => 180, 'stock_quantity' => 150, 'min_stock' => 20],
            ['product_name' => 'White Bread Loaf', 'product_code' => 'BAK-001', 'category_slug' => 'bakery', 'cost_price' => 90, 'selling_price' => 130, 'stock_quantity' => 25, 'min_stock' => 5],
            ['product_name' => 'Chicken Breast 1kg', 'product_code' => 'MET-001', 'category_slug' => 'meat', 'cost_price' => 650, 'selling_price' => 850, 'stock_quantity' => 20, 'min_stock' => 5],
        ];

        $productModels = [];
        foreach ($productsData as $data) {
            $product = Product::firstOrCreate(
                ['product_code' => $data['product_code']],
                [
                    'product_name' => $data['product_name'],
                    'category_id' => $categoryIds[$data['category_slug']],
                    'cost_price' => $data['cost_price'],
                    'selling_price' => $data['selling_price'],
                    'quantity' => $data['stock_quantity'],
                    'reorder_level' => $data['min_stock'],
                ]
            );
            $productModels[] = $product;
        }

        $admin = User::where('email', 'admin@smartmart.com')->first();
        if ($admin) {
            $po = PurchaseOrder::firstOrCreate(
                ['po_number' => 'PO-2026-0001'],
                [
                    'supplier_id' => $supplier->id,
                    'user_id' => $admin->id,
                    'order_date' => now(),
                    'status' => 'approved',
                    'total_amount' => 0,
                    'notes' => 'Initial stock order',
                ]
            );

            $totalAmount = 0;
            foreach ($productModels as $product) {
                $qty = rand(10, 50);
                PurchaseOrderItem::firstOrCreate(
                    ['purchase_order_id' => $po->id, 'product_id' => $product->id],
                    [
                        'quantity' => $qty,
                        'received_quantity' => 0,
                        'unit_price' => $product->cost_price,
                        'total_price' => $qty * $product->cost_price,
                    ]
                );
                $totalAmount += $qty * $product->cost_price;
            }

            $po->total_amount = $totalAmount;
            $po->save();
        }
    }
}
