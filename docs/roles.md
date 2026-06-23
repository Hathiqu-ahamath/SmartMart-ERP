# User Roles & Permissions

## Role Overview

| Role | Slug | Access Level |
|------|------|-------------|
| Administrator | `admin` | Full system access |
| Manager | `manager` | Operations except user/role management |
| Cashier | `cashier` | POS only |
| Storekeeper | `storekeeper` | Inventory, GRN |

## Route Permissions Matrix

| Module | Admin | Manager | Cashier | Storekeeper |
|--------|-------|---------|---------|-------------|
| Dashboard | ✅ | ✅ | ✅ | ✅ |
| Users (CRUD) | ✅ | ❌ | ❌ | ❌ |
| Roles (CRUD) | ✅ | ❌ | ❌ | ❌ |
| Categories | ✅ | ✅ | ❌ | ❌ |
| Products | ✅ | ✅ | ❌ | ❌ |
| Suppliers | ✅ | ✅ | ❌ | ❌ |
| Purchase Orders | ✅ | ✅ | ❌ | ❌ |
| Goods Receipt | ✅ | ✅ | ❌ | ✅ |
| Inventory / Stock | ✅ | ✅ | ❌ | ✅ |
| POS / Sales | ✅ | ✅ | ✅ | ❌ |
| Sales History | ✅ | ✅ | ✅ | ❌ |
| Reports | ✅ | ✅ | ❌ | ❌ |

## Middleware Implementation

Role checking is handled by `RoleMiddleware` (`app/Http/Middleware/RoleMiddleware.php`):

```php
public function handle(Request $request, Closure $next, ...$roles)
{
    $user = $request->user();
    if (!$user || !$user->role) {
        abort(403, 'Unauthorized access.');
    }
    foreach ($roles as $role) {
        if ($user->role->slug === $role) {
            return $next($request);
        }
    }
    abort(403, 'Unauthorized. Required role: ' . implode(', ', $roles));
}
```

Applied in `routes/web.php`:

```php
Route::resource('users', UserController::class)->middleware('role:admin');
Route::resource('categories', CategoryController::class)->middleware('role:admin,manager');
Route::prefix('sales')->middleware('role:admin,manager,cashier')->group(function () { ... });
Route::prefix('grn')->middleware('role:admin,manager,storekeeper')->group(function () { ... });
```

## Sidebar Visibility

The sidebar (`resources/views/layouts/sidebar.blade.php`) conditionally shows admin links:

```blade
@if(auth()->user() && auth()->user()->isAdmin())
    <li class="nav-item">
        <a href="{{ route('users.index') }}">Users</a>
    </li>
@endif
```

The `isAdmin()` method on the User model checks `$this->role?->slug === 'admin'`.

## Default Users (Seeded)

| Name | Email | Role |
|------|-------|------|
| Admin User | admin@smartmart.com | Admin |
| Manager User | manager@smartmart.com | Manager |
| Cashier User | cashier@smartmart.com | Cashier |
| Storekeeper User | storekeeper@smartmart.com | Storekeeper |

All default users have password: `password`
