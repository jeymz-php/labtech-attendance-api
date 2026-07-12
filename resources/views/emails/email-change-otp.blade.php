<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Confirm email</title>
</head>
<body style="margin:0; padding:0; background-color:#F4FBF6; font-family:-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F4FBF6; padding:32px 16px;">
<tr>
<td align="center">
<table role="presentation" width="480" cellpadding="0" cellspacing="0" style="max-width:480px; background-color:#FFFFFF; border-radius:16px; overflow:hidden; border:1px solid #DCEEE3;">

    <tr>
        <td style="background-color:#1E8E5A; padding:28px 32px; text-align:center;">
            <img src="{{ asset('images/ucc.png') }}" alt="UCC logo" width="52" height="52" style="border-radius:12px; background-color:#FFFFFF; padding:6px; display:block; margin:0 auto 12px;">
            <span style="color:#FFFFFF; font-size:16px; font-weight:600;">LabTech Attendance System</span>
        </td>
    </tr>

    <tr>
        <td style="padding:32px; text-align:center;">
            <p style="margin:0 0 4px; color:#6E7D75; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.04em;">Confirm your new email</p>
            <h1 style="margin:0 0 16px; color:#14261C; font-size:20px; font-weight:600;">Hi, {{ $staff->full_name }}</h1>

            <p style="margin:0 0 24px; color:#4A5750; font-size:13.5px; line-height:1.6;">
                Use the code below to confirm this is your new email address. It expires in 10 minutes.
            </p>

            <div style="background-color:#EAF7EF; border:1px solid #DCEEE3; border-radius:12px; padding:20px; margin-bottom:24px;">
                <span style="color:#146B44; font-size:32px; font-weight:700; letter-spacing:6px;">{{ $otp }}</span>
            </div>

            <p style="margin:0; color:#8FA69A; font-size:11px; line-height:1.6;">
                If you did not request this change, you can safely ignore this email.
            </p>
        </td>
    </tr>

</table>
</td>
</tr>
</table>
</body>
</html>