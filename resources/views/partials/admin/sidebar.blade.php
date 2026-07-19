<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SIRT Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">PENGELOLAAN DATA</li>

                <li class="nav-item">
                    <a href="{{ route('admin.residents.index') }}" class="nav-link {{ request()->routeIs('admin.residents.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Data Warga</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Laporan Warga</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.letters.index') }}" class="nav-link {{ request()->routeIs('admin.letters.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>Pembuatan Surat</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.letter-categories.index') }}" class="nav-link {{ request()->routeIs('admin.letter-categories.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Kategori Surat</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.head-of-families.index') }}" class="nav-link {{ request()->routeIs('admin.head-of-families.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Kepala Keluarga</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.news.index') }}" class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>Berita</p>
                    </a>
                </li>

                <li class="nav-header">SISTEM</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Pengaturan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.gemini-configs.index') }}" class="nav-link {{ request()->routeIs('admin.gemini-configs.*') ? 'active' : '' }}">
                                <i class="fas fa-brain nav-icon"></i>
                                <p>Gemini API</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
