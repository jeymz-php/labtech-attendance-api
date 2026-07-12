<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') · LabTech Attendance</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/dist/tabler-icons.min.css">
    <style>
        :root {
            --primary: #1E8E5A;
            --primary-dark: #146B44;
            --sidebar-bg: #123423;
            --sidebar-active: #1E4D33;
            --tint: #EAF7EF;
            --tint-2: #F4FBF6;
            --ink: #14261C;
            --muted: #6E7D75;
            --border: #DCEEE3;
            --warn-bg: #FBEFE0;
            --warn-text: #8A5A0E;
            --danger-bg: #FBE7E3;
            --danger-text: #9C3A28;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--tint-2);
            color: var(--ink);
            font-size: 14px;
        }
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background-color: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            padding: 20px 14px;
        }
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 8px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 18px;
        }
        .sidebar-brand img { width: 34px; height: 34px; border-radius: 8px; background: #fff; padding: 3px; }
        .sidebar-brand .name { color: #fff; font-size: 13px; font-weight: 600; line-height: 1.2; }
        .sidebar-brand .sub { color: rgba(255,255,255,0.55); font-size: 10px; }
        .sidebar-section-label {
            color: rgba(255,255,255,0.4);
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 14px 12px 6px;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            color: rgba(255,255,255,0.75);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            margin-bottom: 2px;
        }
        .sidebar-link i { font-size: 17px; }
        .sidebar-link:hover { background-color: rgba(255,255,255,0.06); color: #fff; }
        .sidebar-link.active { background-color: var(--sidebar-active); color: #fff; }
        .sidebar-link.disabled { opacity: 0.35; pointer-events: none; }
        .main-content { margin-left: 240px; padding: 24px 32px; }
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .topbar h4 { font-weight: 600; margin: 0; }
        .badge-role {
            background-color: #FAEEDA;
            color: #854F0B;
            font-size: 10px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            margin-left: 8px;
            vertical-align: middle;
        }
        .welcome-banner {
            background-color: var(--primary);
            border-radius: 16px;
            padding: 26px 28px;
            color: #fff;
            margin-bottom: 20px;
        }
        .welcome-banner h5 { font-weight: 600; margin-bottom: 4px; }
        .welcome-banner p { color: rgba(255,255,255,0.8); font-size: 12.5px; margin-bottom: 16px; max-width: 520px; }
        .banner-pill {
            display: inline-block;
            background-color: rgba(255,255,255,0.15);
            color: #fff;
            font-size: 11px;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 20px;
            margin-right: 8px;
        }
        .stat-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 16px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .stat-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            background-color: var(--tint);
            color: var(--primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .stat-num { font-size: 20px; font-weight: 600; line-height: 1; }
        .stat-label { font-size: 11px; color: var(--muted); margin-top: 3px; }
        .card-section {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .card-section-header {
            padding: 14px 18px;
            font-weight: 600;
            font-size: 13.5px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        table { font-size: 12.5px; margin-bottom: 0; }
        thead th {
            background-color: var(--tint-2);
            color: var(--muted);
            font-weight: 600;
            font-size: 10.5px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            border-bottom: 1px solid var(--border) !important;
        }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); font-size: 12.5px; }
        .btn-primary:hover { background-color: var(--primary-dark); border-color: var(--primary-dark); }
        .badge-pending { background-color: var(--warn-bg); color: var(--warn-text); }
        .badge-active { background-color: var(--tint); color: var(--primary-dark); }
        .badge-disabled { background-color: var(--danger-bg); color: var(--danger-text); }
        .status-pill { font-size: 10.5px; font-weight: 600; padding: 4px 10px; border-radius: 20px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/ucc.png') }}" alt="UCC logo">
            <div>
                <div class="name">LabTech Attendance</div>
                <div class="sub">Admin Panel</div>
            </div>
        </div>

        <div class="sidebar-section-label">Main</div>
        <a href="{{ route('admin.staff.index') }}" class="sidebar-link {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
            <i class="ti ti-users"></i> Staff accounts
        </a>

        <a href="{{ route('admin.office-hours.edit') }}" class="sidebar-link {{ request()->routeIs('admin.office-hours.*') ? 'active' : '' }}">
            <i class="ti ti-clock"></i> Office hours
        </a>

        <div class="sidebar-section-label">Coming soon</div>
        <span class="sidebar-link disabled"><i class="ti ti-clock-hour-4"></i> Attendance logs</span>
        <span class="sidebar-link disabled"><i class="ti ti-chart-bar"></i> Reports</span>
        <span class="sidebar-link disabled"><i class="ti ti-settings"></i> System settings</span>

        <div class="mt-auto">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="sidebar-link border-0 bg-transparent w-100 text-start" style="color:#F5B8AC;">
                    <i class="ti ti-logout"></i> Log out
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div>
                <h4>@yield('page-title', 'Dashboard') <span class="badge-role">SUPER ADMIN</span></h4>
            </div>
            <div class="text-muted small">{{ now()->format('M d, Y · h:i A') }}</div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>