<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Admin') - Sistem Analisis Beban Kerja</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary-color: #1e5f5f;
            --secondary-color: #2d8f8f;
            --success-color: #27ae60;
            --warning-color: #f1c40f;
            --danger-color: #e74c3c;
            --light-bg: #f0f8f8;
            --dark-text: #1e5f5f;
            --accent-green: #2ecc71;
            --deep-teal: #1a4d4d;
            --bright-green: #00d084;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-text);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 240px;
            background: linear-gradient(135deg, var(--deep-teal), var(--primary-color), var(--secondary-color));
            color: #fff;
            box-shadow: 2px 0 10px rgba(30, 95, 95, 0.2);
            padding: 1rem;
            overflow-y: auto;
        }
        .sidebar .brand {
            font-weight: bold;
            color: #fff;
            display: flex;
            align-items: center;
            gap: .5rem;
            margin-bottom: 1rem;
        }
        .sidebar .nav-link {
            color: #fff;
            border-radius: 8px;
            padding: .6rem .75rem;
            margin-bottom: .35rem;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,.15);
        }
        .notification-badge {
            background-color: var(--danger-color);
            color: #fff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Content wrapper */
        .content-wrapper {
            margin-left: 240px;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 2rem;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        .btn-primary { background-color: var(--secondary-color); border-color: var(--secondary-color); border-radius: 10px; padding: 10px 20px; font-weight: 500; transition: all 0.3s ease; }
        .btn-primary:hover { background-color: #2980b9; border-color: #2980b9; transform: translateY(-2px); }
        .btn-success { background-color: var(--success-color); border-color: var(--success-color); border-radius: 10px; }
        .btn-warning { background-color: var(--warning-color); border-color: var(--warning-color); border-radius: 10px; }
        .btn-danger { background-color: var(--danger-color); border-color: var(--danger-color); border-radius: 10px; }

        .form-control { border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 15px; transition: border-color 0.3s ease; }
        .form-control:focus { border-color: var(--secondary-color); box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25); }

        .table { border-radius: 10px; overflow: hidden; }
        .table thead th { background-color: var(--primary-color); color: white; border: none; font-weight: 600; }

        .badge { border-radius: 20px; padding: 8px 12px; font-weight: 500; }

        .stats-card { background: linear-gradient(135deg, var(--secondary-color), var(--accent-green), var(--bright-green)); color: white; position: relative; overflow: hidden; }
        .stats-card::before { content: ''; position: absolute; inset: 0; background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="confetti" x="0" y="0" width="25" height="25" patternUnits="userSpaceOnUse"><rect width="1" height="1" fill="%23f1c40f" opacity="0.2"/></pattern></defs><rect width="100" height="100" fill="url(%23confetti)"/></svg>'); opacity: 0.1; }
        .stats-card .card-body { padding: 2rem; }
        .stats-number { font-size: 2.5rem; font-weight: bold; margin-bottom: 0.5rem; }

        .alert { border: none; border-radius: 15px; padding: 15px 20px; }

        .admin-card { background: linear-gradient(135deg, var(--deep-teal), var(--primary-color), var(--secondary-color)); color: white; position: relative; overflow: hidden; }
        .admin-card::before { content: ''; position: absolute; inset: 0; background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="confetti" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><rect width="2" height="2" fill="%23f1c40f" opacity="0.3"/></pattern></defs><rect width="100" height="100" fill="url(%23confetti)"/></svg>'); opacity: 0.1; }

        .loading { display: none; }
        .loading.show { display: block; }

        @media (max-width: 992px) {
            .sidebar { width: 200px; }
            .content-wrapper { margin-left: 200px; }
        }
        @media (max-width: 768px) {
            .sidebar { position: fixed; transform: translateX(-100%); transition: transform .3s ease; z-index: 1040; }
            .sidebar.show { transform: translateX(0); }
            .content-wrapper { margin-left: 0; padding-top: 60px; }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <i class="fas fa-user-shield"></i>
            <span>Admin Panel</span>
        </div>
        <div class="mb-3 small">{{ Auth::user()->name }}</div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-home me-2"></i>Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('admin.kelola-tugas*') ? 'active' : '' }}" href="{{ route('admin.kelola-tugas') }}">
                <i class="fas fa-tasks me-2"></i>Kelola Tugas
            </a>
            <a class="nav-link {{ request()->routeIs('admin.kelola-akun*') ? 'active' : '' }}" href="{{ route('admin.kelola-akun') }}">
                <i class="fas fa-users me-2"></i>Kelola Akun
            </a>
            
            <!-- Sistem & Laporan with Submenu -->
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}" 
                   data-bs-toggle="collapse" 
                   href="#laporanSubmenu" 
                   role="button" 
                   aria-expanded="{{ request()->routeIs('admin.laporan*') ? 'true' : 'false' }}"
                   style="cursor: pointer;">
                    <i class="fas fa-chart-line me-2"></i>Sistem & Laporan
                    <i class="fas fa-chevron-down float-end mt-1"></i>
                </a>
                <div class="collapse {{ request()->routeIs('admin.laporan*') ? 'show' : '' }}" id="laporanSubmenu">
                    <div class="nav flex-column ms-3">
                        <a class="nav-link {{ request()->routeIs('admin.laporan.pegawai') ? 'active' : '' }}" 
                           href="{{ route('admin.laporan.pegawai') }}" 
                           style="padding: 0.4rem 0.75rem; font-size: 0.9rem;">
                            <i class="fas fa-users me-2"></i>Data Pegawai
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.laporan.unit') ? 'active' : '' }}" 
                           href="{{ route('admin.laporan.unit') }}"
                           style="padding: 0.4rem 0.75rem; font-size: 0.9rem;">
                            <i class="fas fa-building me-2"></i>Data Unit
                        </a>
                    </div>
                </div>
            </div>
            
            <a class="nav-link {{ request()->routeIs('admin.notifikasi-perubahan*') ? 'active' : '' }} position-relative" href="{{ route('admin.notifikasi-perubahan') }}">
                <i class="fas fa-bell me-2"></i>Notifikasi
                @if($unreadNotifications ?? 0 > 0)
                    <span class="notification-badge ms-2">{{ $unreadNotifications ?? 0 }}</span>
                @endif
            </a>
            <hr>
            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="btn btn-sm btn-light w-100 text-start"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="content-wrapper">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <script>
        // Sidebar toggle for mobile (optional hook if you add a button)
        $('#sidebarToggle').on('click', function() {
            $('#sidebar').toggleClass('show');
        });

        // Auto hide alerts (except reason alerts)
        setTimeout(function() {
            $('.alert:not(.alert-primary)').fadeOut('slow');
        }, 5000);

        // Loading state for forms
        $('form').on('submit', function() {
            $(this).find('.btn').prop('disabled', true);
            $(this).find('.loading').addClass('show');
        });

        // Confirm delete
        $('.btn-delete').on('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                e.preventDefault();
            }
        });

        // Toggle password visibility
        $('.toggle-password').on('click', function() {
            const input = $(this).siblings('input');
            const icon = $(this).find('i');
            
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>
