<aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
    <a href="../../index3.html" class="brand-link">
        <img src="{{ asset('admin/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('admin/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview"
                role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Tổng quan</p>
                    </a>
                </li>
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>
                            Sản phẩm
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.products.index') }}"
                                class="nav-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                                <p>Quản lý sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.products.create') }}"
                                class="nav-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                                <p>Thêm sản phẩm mới</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.index') }}"
                                class="nav-link {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}">
                                <p>Quản lý danh mục</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.suppliers.index') }}"
                                class="nav-link {{ request()->routeIs('admin.suppliers.index') ? 'active' : '' }}">
                                <p>Quản lý nhà cung cấp</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>

    <div class="sidebar-custom">
        <a href="#" class="btn btn-link">
            <i class="fas fa-cogs"></i>
        </a>
        <form action="{{ route('logout') }}" method="post" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-secondary hide-on-collapse pos-right">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>
    </div>
</aside>
