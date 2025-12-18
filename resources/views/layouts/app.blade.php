<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Penilaian Kinerja - @yield('title')</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --sidebar-width: 240px;
            --sidebar-collapsed: 70px;
            --sidebar-bg: #1a1a2e;
            --sidebar-text: #a0aec0;
            --sidebar-active: #fff;
            --sidebar-active-bg: #16213e;
            --main-bg: #f7f8fc;
            --card-border: #e2e8f0;
            --text-primary: #1a202c;
            --text-secondary: #718096;
        }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: var(--main-bg); }
        .sidebar { min-height: 100vh; background: var(--sidebar-bg); position: fixed; width: var(--sidebar-width); padding: 0; transition: all 0.2s ease; z-index: 1050; left: 0; top: 0; }
        .sidebar.collapsed { width: var(--sidebar-collapsed); }
        .sidebar-brand { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); white-space: nowrap; overflow: hidden; }
        .sidebar.collapsed .sidebar-brand { padding: 24px 15px; text-align: center; }
        .sidebar-brand h5 { color: #fff; font-weight: 600; margin: 0; font-size: 16px; }
        .sidebar-brand small { color: var(--sidebar-text); font-size: 12px; }
        .sidebar.collapsed .sidebar-brand h5, .sidebar.collapsed .sidebar-brand small { display: none; }
        .sidebar.collapsed .sidebar-brand::after { content: 'SPK'; color: #fff; font-weight: 600; font-size: 14px; }
        .sidebar .nav { padding: 16px 0; }
        .sidebar .nav-link { color: var(--sidebar-text); padding: 12px 20px; font-size: 14px; border-left: 3px solid transparent; display: flex; align-items: center; gap: 12px; white-space: nowrap; overflow: hidden; }
        .sidebar.collapsed .nav-link { padding: 12px 0; justify-content: center; border-left: none; }
        .sidebar.collapsed .nav-link span { display: none; }
        .sidebar .nav-link:hover { color: var(--sidebar-active); background: var(--sidebar-active-bg); }
        .sidebar .nav-link.active { color: var(--sidebar-active); background: var(--sidebar-active-bg); border-left-color: #4f46e5; }
        .sidebar.collapsed .nav-link.active { border-left-color: transparent; }
        .sidebar .nav-link i { font-size: 18px; min-width: 20px; text-align: center; }
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1040; }
        .sidebar-overlay.show { display: block; }
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; padding: 0; transition: margin-left 0.2s ease; }
        .main-content.expanded { margin-left: var(--sidebar-collapsed); }
        .topbar { background: #fff; padding: 12px 24px; border-bottom: 1px solid var(--card-border); display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 1020; }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .topbar h4 { margin: 0; font-size: 16px; font-weight: 600; color: var(--text-primary); }
        .btn-toggle { background: transparent; border: 1px solid var(--card-border); color: var(--text-secondary); width: 38px; height: 38px; border-radius: 6px; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .btn-toggle:hover { background: #f1f5f9; color: var(--text-primary); }
        .content-area { padding: 24px; }
        .card { border: 1px solid var(--card-border); border-radius: 8px; background: #fff; }
        .card-header { background: #fff; border-bottom: 1px solid var(--card-border); padding: 16px 20px; }
        .card-header h5 { margin: 0; font-size: 15px; font-weight: 600; }
        .card-body { padding: 20px; }
        .stat-card { border-radius: 8px; padding: 20px; background: #fff; border: 1px solid var(--card-border); }
        .stat-card .stat-icon { width: 48px; height: 48px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 16px; }
        .stat-card .stat-icon.blue { background: #eff6ff; color: #3b82f6; }
        .stat-card .stat-icon.green { background: #f0fdf4; color: #22c55e; }
        .stat-card .stat-icon.orange { background: #fff7ed; color: #f97316; }
        .stat-card .stat-icon.purple { background: #faf5ff; color: #a855f7; }
        .stat-card h3 { font-size: 28px; font-weight: 700; margin: 0 0 4px 0; color: var(--text-primary); }
        .stat-card p { margin: 0; color: var(--text-secondary); font-size: 13px; }
        .table { font-size: 14px; margin-bottom: 0; width: 100% !important; }
        .table th { font-weight: 600; color: var(--text-secondary); text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; border-bottom-width: 1px; padding: 12px 16px; background: #f8fafc; }
        .table td { padding: 12px 16px; vertical-align: middle; color: var(--text-primary); }
        .btn { font-size: 14px; padding: 8px 16px; border-radius: 6px; font-weight: 500; }
        .btn-sm { padding: 6px 12px; font-size: 13px; }
        .btn-primary { background: #4f46e5; border-color: #4f46e5; }
        .btn-primary:hover { background: #4338ca; border-color: #4338ca; }
        .btn-secondary { background: #64748b; border-color: #64748b; }
        .btn-danger { background: #ef4444; border-color: #ef4444; }
        .btn-warning { background: #f59e0b; border-color: #f59e0b; color: #fff; }
        .btn-warning:hover { background: #d97706; border-color: #d97706; color: #fff; }
        .btn-info { background: #06b6d4; border-color: #06b6d4; color: #fff; }
        .btn-info:hover { background: #0891b2; border-color: #0891b2; color: #fff; }
        .btn-success { background: #22c55e; border-color: #22c55e; }
        .badge { font-weight: 500; padding: 5px 10px; font-size: 12px; border-radius: 4px; }
        .form-control, .form-select { font-size: 14px; padding: 10px 14px; border-radius: 6px; border: 1px solid #d1d5db; }
        .form-control:focus, .form-select:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.1); }
        .form-label { font-size: 13px; font-weight: 500; color: var(--text-primary); margin-bottom: 6px; }
        .alert { border-radius: 8px; font-size: 14px; border: none; }
        .alert-success { background: #f0fdf4; color: #166534; }
        .alert-danger { background: #fef2f2; color: #991b1b; }
        .alert-info { background: #eff6ff; color: #1e40af; }
        .alert-warning { background: #fffbeb; color: #92400e; }
        .dropdown-menu { border: 1px solid var(--card-border); border-radius: 8px; padding: 8px; }
        .dropdown-item { border-radius: 4px; font-size: 14px; padding: 8px 12px; }
        .user-dropdown { background: transparent; border: 1px solid var(--card-border); color: var(--text-primary); }
        /* DataTables Styling */
        .dataTables_wrapper { padding-top: 0; }
        .dataTables_length, .dataTables_filter { padding: 15px 20px 10px; }
        .dataTables_info, .dataTables_paginate { padding: 10px 20px 15px; }
        .dataTables_filter input { border: 1px solid #d1d5db; border-radius: 6px; padding: 6px 12px; margin-left: 8px; }
        .dataTables_length select { border: 1px solid #d1d5db; border-radius: 6px; padding: 4px 8px; }
        .paginate_button { padding: 5px 10px !important; margin: 0 2px !important; border-radius: 4px !important; }
        .paginate_button.current { background: #4f46e5 !important; border-color: #4f46e5 !important; color: white !important; }
        @media (max-width: 991.98px) {
            .sidebar { left: -260px; width: var(--sidebar-width) !important; }
            .sidebar.mobile-show { left: 0; }
            .main-content { margin-left: 0 !important; }
            .content-area { padding: 16px; }
            .topbar { padding: 12px 16px; }
            .topbar h4 { font-size: 14px; }
            .stat-card { padding: 16px; }
            .stat-card h3 { font-size: 24px; }
            .card-header, .card-body { padding: 16px; }
            .user-dropdown span { display: none; }
        }
    </style>
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h5>SPK Pegawai</h5>
            <small>DISKOMINFOTIKSAN</small>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-grid"></i> <span>Dashboard</span>
                </a>
            </li>
            @if(auth()->user()->role === 'admin')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pegawai.*') ? 'active' : '' }}" href="{{ route('pegawai.index') }}">
                    <i class="bi bi-people"></i> <span>Data Pegawai</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('kriteria.*') || request()->routeIs('subkriteria.*') ? 'active' : '' }}" href="{{ route('kriteria.index') }}">
                    <i class="bi bi-list-check"></i> <span>Kriteria</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('penilaian.*') ? 'active' : '' }}" href="{{ route('penilaian.index') }}">
                    <i class="bi bi-clipboard-data"></i> <span>Penilaian</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('perhitungan.*') ? 'active' : '' }}" href="{{ route('perhitungan.index') }}">
                    <i class="bi bi-calculator"></i> <span>Perhitungan</span>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('perbandingan') ? 'active' : '' }}" href="{{ route('perbandingan') }}">
                    <i class="bi bi-bar-chart"></i> <span>Hasil & Laporan</span>
                </a>
            </li>
        </ul>
    </nav>

    <main class="main-content" id="mainContent">
        <div class="topbar">
            <div class="topbar-left">
                <button class="btn-toggle" id="toggleSidebar" title="Toggle Sidebar">
                    <i class="bi bi-list"></i>
                </button>
                <h4>@yield('title')</h4>
            </div>
            <div class="dropdown">
                <button class="btn user-dropdown dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-1"></i><span>{{ auth()->user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-item-text text-muted small">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content-area">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @yield('content')
        </div>
    </main>
    
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        // Sidebar
        var sidebar = document.getElementById('sidebar');
        var mainContent = document.getElementById('mainContent');
        var toggleBtn = document.getElementById('toggleSidebar');
        var overlay = document.getElementById('sidebarOverlay');
        
        function isMobile() { return window.innerWidth < 992; }
        function closeMobileSidebar() {
            sidebar.classList.remove('mobile-show');
            overlay.classList.remove('show');
        }
        
        if (!isMobile() && localStorage.getItem('sidebarCollapsed') === 'true') {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
        }
        
        toggleBtn.onclick = function() {
            if (isMobile()) {
                sidebar.classList.toggle('mobile-show');
                overlay.classList.toggle('show');
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            }
        };
        
        overlay.onclick = closeMobileSidebar;
    </script>
    
    @yield('scripts')
</body>
</html>
