<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="/admin" class="nav-link {{ in_array('Dashboard', $breadcumbs['titles']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/users"
                        class="nav-link {{ in_array('Users', $breadcumbs['titles']) ? 'active' : '' }}">
                        <i class="nav-icon far fas fa-user"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/categories"
                        class="nav-link {{ in_array('Categories', $breadcumbs['titles']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            Categories
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/brands"
                        class="nav-link {{ in_array('Brands', $breadcumbs['titles']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-copyright"></i>
                        <p>
                            Brands
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/products"
                        class="nav-link {{ in_array('Products', $breadcumbs['titles']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>
                            Products
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/customers"
                        class="nav-link {{ in_array('Customers', $breadcumbs['titles']) ? 'active' : '' }}">
                        <i class="nav-icon far fas fa-user"></i>
                        <p>
                            Customers
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.home') }}"
                        class="nav-link {{ in_array('Orders', $breadcumbs['titles']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>
                            Orders
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
