<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Consultations Export</title>
    <style>
        body { font-family: Arial, sans-serif; color: #0f172a; margin: 24px; }
        h2 { margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { border: 1px solid #e5e7eb; padding: 8px; text-align: left; }
        th { background: #f8fafc; font-weight: 700; }
        tr:nth-child(even) { background: #f9fafb; }
    </style>
</head>
<body>
    <h2>Consultations</h2>
    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Scheduled For</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($consultations as $consultation)
            <tr>
                <td>{{ $consultation->name }}</td>
                <td>{{ $consultation->email }}</td>
                <td>{{ $consultation->phone }}</td>
                <td>{{ optional($consultation->scheduled_for)->format('Y-m-d') }}</td>
                <td>{{ $consultation->status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
