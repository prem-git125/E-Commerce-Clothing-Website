@php
    $routes = [
        ['name' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'bi bi-speedometer2'],
        ['name' => 'Users', 'route' => 'admin.users', 'icon' => 'bi bi-people'],
        ['name' => 'Categories', 'route' => 'admin.categories', 'icon' => 'bi bi-tags'],
    ];
@endphp

<nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3">
        <h4 class="text-white">Admin Pannel</h4>
        @foreach ($routes as $route)
            <a href="{{ route($route['route']) }}" class="{{ request()->routeIs($route['route']) ? 'active-link' : '' }}">
                <i class="{{ $route['icon'] }}"></i> {{ $route['name'] }}
            </a>
        @endforeach
    </div>

    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="" width="32" height="32"
                class="rounded-circle me-2">
            <strong>{{ Auth::user()->name ?? 'None' }}</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1" style="">
            <li>
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout</button>
                </form>
            </li>
        </ul>
    </div>
</nav>
