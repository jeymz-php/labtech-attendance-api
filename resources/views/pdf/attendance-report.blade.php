<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body { font-family: sans-serif; color: #14261C; font-size: 11px; }
    .header { background-color: #1E8E5A; color: #fff; padding: 16px 20px; border-radius: 8px; margin-bottom: 16px; }
    .header h2 { margin: 0 0 2px; font-size: 15px; }
    .header p { margin: 0; font-size: 10px; color: #EAF7EF; }
    .meta { margin-bottom: 14px; }
    .meta td { padding: 2px 0; font-size: 10.5px; }
    .meta .label { color: #6E7D75; width: 110px; }
    table.logs { width: 100%; border-collapse: collapse; }
    table.logs th { background-color: #EAF7EF; color: #146B44; text-align: left; padding: 6px 8px; font-size: 10px; text-transform: uppercase; }
    table.logs td { padding: 6px 8px; border-bottom: 1px solid #DCEEE3; font-size: 10.5px; }
    .status { padding: 2px 8px; border-radius: 10px; font-size: 9px; }
    .status-on_time { background-color: #EAF3EE; color: #146B44; }
    .status-late { background-color: #FBEFE0; color: #8A5A0E; }
    .footer { margin-top: 20px; font-size: 9px; color: #8FA69A; text-align: center; }
</style>
</head>
<body>

    <div class="header">
        <h2>LabTech Attendance Report</h2>
        <p>University of Caloocan City · LabTech Office</p>
    </div>

    <table class="meta" width="100%">
        <tr><td class="label">Staff name</td><td>{{ $staff->full_name }}</td></tr>
        <tr><td class="label">Staff ID</td><td>{{ $staff->staff_id }}</td></tr>
        <tr><td class="label">Campus</td><td>{{ $staff->campus }}</td></tr>
        <tr><td class="label">Generated on</td><td>{{ $generatedAt->format('M d, Y · h:i A') }} ({{ $timezone }})</td></tr>
    </table>

    <table class="logs">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time in</th>
                <th>Time out</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($log->log_date)->format('M d, Y') }}</td>
                    <td>{{ $log->time_in ? $log->time_in->timezone($timezone)->format('h:i A') : '—' }}</td>
                    <td>{{ $log->time_out ? $log->time_out->timezone($timezone)->format('h:i A') : '—' }}</td>
                    <td><span class="status status-{{ $log->status }}">{{ ucfirst(str_replace('_', ' ', $log->status)) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="4">No attendance records found for this range.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer">This is a system-generated report from the LabTech Attendance Monitoring System.</p>

</body>
</html>