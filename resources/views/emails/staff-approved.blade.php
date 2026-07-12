<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Account approved</title>
</head>
<body style="margin:0; padding:0; background-color:#F4FBF6; font-family:-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F4FBF6; padding:32px 16px;">
<tr>
<td align="center">
<table role="presentation" width="480" cellpadding="0" cellspacing="0" style="max-width:480px; background-color:#FFFFFF; border-radius:16px; overflow:hidden; border:1px solid #DCEEE3;">

    <!-- Header -->
    <tr>
        <td style="background-color:#1E8E5A; padding:28px 32px; text-align:center;">
            <img src="{{ asset('images/ucc.png') }}" alt="UCC logo" width="52" height="52" style="border-radius:12px; background-color:#FFFFFF; padding:6px; display:block; margin:0 auto 12px;">
            <span style="color:#FFFFFF; font-size:16px; font-weight:600; letter-spacing:0.2px;">LabTech Attendance System</span>
        </td>
    </tr>

    <!-- Body -->
    <tr>
        <td style="padding:32px;">
            <p style="margin:0 0 4px; color:#6E7D75; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.04em;">Account approved</p>
            <h1 style="margin:0 0 16px; color:#14261C; font-size:20px; font-weight:600;">Welcome, {{ $staff->full_name }}</h1>

            <p style="margin:0 0 20px; color:#4A5750; font-size:13.5px; line-height:1.6;">
                Your LabTech Office staff account has been approved by the Super Admin.
                Use the credentials below to sign in on the LabTech Attendance app.
            </p>

            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#EAF7EF; border-radius:12px; border:1px solid #DCEEE3; margin-bottom:20px;">
                <tr>
                    <td style="padding:16px 20px;">
                        <p style="margin:0 0 2px; color:#6E7D75; font-size:10.5px; font-weight:600; text-transform:uppercase; letter-spacing:0.04em;">Staff ID</p>
                        <p style="margin:0 0 14px; color:#14261C; font-size:15px; font-weight:600;">{{ $staff->staff_id }}</p>

                        <p style="margin:0 0 2px; color:#6E7D75; font-size:10.5px; font-weight:600; text-transform:uppercase; letter-spacing:0.04em;">Temporary password</p>
                        <p style="margin:0; color:#146B44; font-size:18px; font-weight:700; letter-spacing:0.5px;">{{ $generatedPassword }}</p>
                    </td>
                </tr>
            </table>

            <p style="margin:0 0 24px; color:#6E7D75; font-size:12px; line-height:1.6;">
                For your security, please sign in and change this password as soon as possible.
                Do not share this email or your credentials with anyone.
            </p>

            <table role="presentation" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="background-color:#1E8E5A; border-radius:10px;">
                        <a href="#" style="display:inline-block; padding:12px 28px; color:#FFFFFF; font-size:13px; font-weight:600; text-decoration:none;">Open the app to sign in</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="padding:20px 32px; border-top:1px solid #DCEEE3; text-align:center;">
            <p style="margin:0; color:#8FA69A; font-size:10.5px; line-height:1.6;">
                University of Caloocan City · LabTech Office<br>
                This is an automated message, please do not reply to this email.
            </p>
        </td>
    </tr>

</table>
</td>
</tr>
</table>
</body>
</html>