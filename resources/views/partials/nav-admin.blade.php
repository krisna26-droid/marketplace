<nav class="w-64 h-screen bg-white border-r p-4">
    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-lg font-bold">Admin Dashboard</a>
    </div>

    <ul class="space-y-2 text-sm">
        <li><a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Dashboard</a></li>
        <li><a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Manage Users</a></li>
        <li><a href="{{ route('admin.categories.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Manage Categories</a></li>
        <li><a href="{{ route('admin.products.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Manage Products</a></li>
        <li><a href="{{ route('admin.orders.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Orders</a></li>
        <li><a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Profile</a></li>
    </ul>

    <div class="mt-auto pt-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-3 py-2 rounded hover:bg-gray-100">Logout</button>
        </form>
    </div>
</nav>
