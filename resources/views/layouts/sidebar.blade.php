<nav class="sidebar" id="sidebar">
    <div class="brand">
        <h4><i class="bi bi-shop"></i> SmartMart</h4>
        <small>Enterprise ERP System</small>
    </div>
    <ul class="nav flex-column" style="list-style: none; padding: 0;">
        <li class="nav-header">Main Menu</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        @if(auth()->user() && auth()->user()->isAdmin())
        <li class="nav-header">Administration</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                <i class="bi bi-people"></i> Users
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                <i class="bi bi-shield-lock"></i> Roles
            </a>
        </li>
        @endif
        <li class="nav-header">Inventory</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                <i class="bi bi-tags"></i> Categories
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                <i class="bi bi-box"></i> Products
                @if(isset($lowStockCount) && $lowStockCount > 0)
                    <span class="badge bg-danger ms-auto">{{ $lowStockCount }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                <i class="bi bi-truck"></i> Suppliers
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}" href="{{ route('purchases.index') }}">
                <i class="bi bi-cart-plus"></i> Purchase Orders
                @if(isset($pendingPoCount) && $pendingPoCount > 0)
                    <span class="badge bg-warning ms-auto">{{ $pendingPoCount }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('grn.*') ? 'active' : '' }}" href="{{ route('grn.index') }}">
                <i class="bi bi-box-seam"></i> Goods Receipt
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}" href="{{ route('inventory.index') }}">
                <i class="bi bi-clipboard-data"></i> Stock
            </a>
        </li>
        <li class="nav-header">Sales</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('sales.pos') ? 'active' : '' }}" href="{{ route('sales.pos') }}">
                <i class="bi bi-cart"></i> POS Billing
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('sales.index') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                <i class="bi bi-receipt"></i> Sales History
            </a>
        </li>
        <li class="nav-header">Reports</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('reports.daily') ? 'active' : '' }}" href="{{ route('reports.daily') }}">
                <i class="bi bi-calendar-day"></i> Daily Report
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('reports.monthly') ? 'active' : '' }}" href="{{ route('reports.monthly') }}">
                <i class="bi bi-calendar-month"></i> Monthly Report
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('reports.inventory') ? 'active' : '' }}" href="{{ route('reports.inventory') }}">
                <i class="bi bi-graph-up"></i> Inventory Report
            </a>
        </li>
    </ul>
</nav>
