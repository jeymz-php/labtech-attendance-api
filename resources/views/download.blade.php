<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download · LabTech Attendance</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F4FBF6; margin: 0; padding: 40px 20px; }
        .card { max-width: 460px; margin: 0 auto; background: #fff; border-radius: 20px; padding: 36px 30px; text-align: center; border: 1px solid #DCEEE3; }
        .logo { width: 72px; height: 72px; border-radius: 16px; background: #1E8E5A; padding: 10px; margin-bottom: 18px; }
        h1 { font-size: 19px; color: #14261C; margin: 0 0 6px; font-weight: 600; }
        p.sub { color: #6E7D75; font-size: 13px; margin: 0 0 26px; }
        .btn { display: inline-block; background: #1E8E5A; color: #fff; text-decoration: none; font-weight: 600; font-size: 14px; padding: 14px 32px; border-radius: 12px; }
        .version { color: #8FA69A; font-size: 11px; margin-top: 14px; }
        .steps { text-align: left; margin-top: 30px; padding: 18px 20px; background: #EAF7EF; border-radius: 12px; font-size: 12px; color: #4A5750; line-height: 1.7; }
        .steps b { color: #14261C; }
    </style>
</head>
<body>
    <div class="card">
        <img src="{{ asset('images/ucc.png') }}" alt="UCC logo" class="logo">
        <h1>LabTech Attendance System</h1>
        <p class="sub">University of Caloocan City · LabTech Office</p>

        <a href="{{ route('app.download') }}" class="btn">Download for Android</a>
        <p class="version">Version {{ $version }}</p>

        <div class="steps">
            <b>Installation steps:</b><br>
            1. Tap the download button above.<br>
            2. If prompted, allow "Install from this source."<br>
            3. Open the downloaded file and tap Install.<br>
            4. Once installed, open the app and sign in with your Staff ID.
        </div>
    </div>
</body>
</html>