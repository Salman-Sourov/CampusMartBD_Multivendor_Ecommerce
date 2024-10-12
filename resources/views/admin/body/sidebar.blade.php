<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.home') }}" class="sidebar-brand">
            Bazar<span>BD</span>
        </a>
    </div>

    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{ route('admin.home') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item nav-category">Bazar BD</li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false"
                    aria-controls="emails">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Brands</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="emails">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('brand.index') }}" class="nav-link">All Brands</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#category" role="button" aria-expanded="false"
                    aria-controls="category">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Category</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="category">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('category.index') }}" class="nav-link">All Category</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
