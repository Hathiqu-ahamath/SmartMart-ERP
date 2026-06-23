<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;
    public function test_admin_can_access_admin_routes()
    {
        $role = Role::factory()->create(['slug' => 'admin', 'name' => 'Admin']);
        $user = User::factory()->create(['role_id' => $role->id]);
        $response = $this->actingAs($user)->get('/users');
        $response->assertStatus(200);
    }
    public function test_non_admin_cannot_access_admin_routes()
    {
        $role = Role::factory()->create(['slug' => 'cashier', 'name' => 'Cashier']);
        $user = User::factory()->create(['role_id' => $role->id]);
        $response = $this->actingAs($user)->get('/users');
        $response->assertStatus(403);
    }
}
