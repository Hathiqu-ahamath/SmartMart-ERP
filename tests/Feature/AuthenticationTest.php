<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
    public function test_login_page_loads()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('SmartMart ERP');
    }
    public function test_user_can_login_with_valid_credentials()
    {
        $role = Role::factory()->create(['slug' => 'admin', 'name' => 'Admin']);
        $user = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
        ]);
        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }
    public function test_user_cannot_login_with_invalid_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'nonexistent@test.com',
            'password' => 'wrongpassword',
        ]);
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
    public function test_authenticated_user_can_access_dashboard()
    {
        $role = Role::factory()->create(['slug' => 'admin', 'name' => 'Admin']);
        $user = User::factory()->create(['role_id' => $role->id]);
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
    }
    public function test_guest_cannot_access_dashboard()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }
}
