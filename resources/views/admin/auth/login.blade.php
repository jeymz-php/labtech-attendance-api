<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin login · LabTech Attendance</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/dist/tabler-icons.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .split-wrap { min-height: 100vh; display: flex; }
        .left-pane {
            flex: 1;
            background-color: #1E8E5A;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
        }
        .left-pane img { width: 84px; height: 84px; border-radius: 14px; background: #fff; padding: 8px; margin-bottom: 24px; }
        .left-pane h2 { font-weight: 600; margin-bottom: 8px; }
        .left-pane p.lead-text { color: rgba(255,255,255,0.8); font-size: 13.5px; margin-bottom: 28px; }
        .feature-item { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; font-size: 12.5px; }
        .feature-item i { color: #fff; background: rgba(255,255,255,0.18); border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 12px; }
        .right-pane {
            width: 440px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            padding: 40px;
        }
        .login-box { width: 100%; max-width: 320px; }
        .app-chip { display: flex; align-items: center; gap: 10px; margin-bottom: 26px; }
        .app-chip .icon { width: 40px; height: 40px; border-radius: 10px; background: #EAF7EF; display: flex; align-items: center; justify-content: center; color: #1E8E5A; font-size: 18px; }
        .app-chip .name { font-size: 12.5px; font-weight: 600; color: #14261C; line-height: 1.2; }
        .app-chip .sub { font-size: 10.5px; color: #6E7D75; }
        label.field-label { font-size: 10.5px; font-weight: 600; color: #6E7D75; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 6px; }
        .form-control { border-radius: 10px; border-color: #DCEEE3; font-size: 13px; padding: 10px 14px; }
        .btn-primary { background-color: #1E8E5A; border-color: #1E8E5A; border-radius: 10px; font-size: 13px; font-weight: 600; padding: 10px; }
        .btn-primary:hover { background-color: #146B44; border-color: #146B44; }
    </style>
</head>
<body>
    <div class="split-wrap">
        <div class="left-pane d-none d-md-flex">
            <img src="{{ asset('images/ucc.png') }}" alt="UCC logo">
            <h2>LabTech Attendance<br>Monitoring System</h2>
            <p class="lead-text">Super Admin panel for the University of Caloocan City LabTech Office — approve staff accounts and monitor attendance across all campuses.</p>

            <div class="feature-item"><i class="ti ti-check"></i> Approve and manage staff accounts</div>
            <div class="feature-item"><i class="ti ti-check"></i> Monitor daily attendance logs</div>
            <div class="feature-item"><i class="ti ti-check"></i> Multi-campus visibility</div>
            <div class="feature-item"><i class="ti ti-check"></i> Generate attendance reports</div>
        </div>

        <div class="right-pane">
            <div class="login-box">
                <div class="app-chip">
                    <div class="icon"><i class="ti ti-shield-lock"></i></div>
                    <div>
                        <div class="name">LabTech Attendance</div>
                        <div class="sub">Super Admin panel</div>
                    </div>
                </div>

                <h5 class="fw-semibold mb-1">Welcome back</h5>
                <p class="text-muted small mb-4">Sign in to access the admin dashboard.</p>

                @if ($errors->any())
                    <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="field-label">Email address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="admin@ucc.edu.ph" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="field-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-2">Sign in</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>