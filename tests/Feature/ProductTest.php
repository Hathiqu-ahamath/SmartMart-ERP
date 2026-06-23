<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
class ProductTest extends TestCase
{
    use RefreshDatabase;
    public function test_product_list_loads()
    {
        $role = Role::factory()->create(['slug' => 'admin', 'name' => 'Admin']);
        $user = User::factory()->create(['role_id' => $role->id]);
        $response = $this->actingAs($user)->get('/products');
        $response->assertStatus(200);
    }
    public function test_product_creation()
    {
        $role = Role::factory()->create(['slug' => 'admin', 'name' => 'Admin']);
        $user = User::factory()->create(['role_id' => $role->id]);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->post('/products', [
            'product_code' => 'PRD-001',
            'product_name' => 'Test Product',
            'category_id' => $category->id,
            'cost_price' => 10.00,
            'selling_price' => 15.00,
            'quantity' => 100,
            'reorder_level' => 10,
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('products', ['product_code' => 'PRD-001']);
    }
    public function test_product_validation()
    {
        $role = Role::factory()->create(['slug' => 'admin', 'name' => 'Admin']);
        $user = User::factory()->create(['role_id' => $role->id]);
        $response = $this->actingAs($user)->post('/products', []);
        $response->assertSessionHasErrors(['product_code', 'product_name', 'category_id', 'cost_price', 'selling_price', 'quantity', 'reorder_level']);
    }
}
