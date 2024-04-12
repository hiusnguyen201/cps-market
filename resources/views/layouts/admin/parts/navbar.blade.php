<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/admin" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="/admin/settings/password"><span
                    class="mr-2">{{ Auth::user()->name ?? '' }}</span><i class="fas fa-user-cog"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/auth/logout"><i class="fas fa-sign-out-alt"></i></a>
        </li>
    </ul>
</nav>
