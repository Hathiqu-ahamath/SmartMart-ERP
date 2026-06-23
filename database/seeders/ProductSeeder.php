<?php
namespace Database\Seeders;
use App\Models\Category;
use App\Models\Product;
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
    }
}
