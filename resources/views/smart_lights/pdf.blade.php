<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Lights Report</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 20px;
            color: #333;
        }
        h1 {
            color: #2b6cb0;
            text-align: center;
            margin-bottom: 20px;
        }
        .header-info {
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background-color: #4299e1;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 10px;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f2f7ff;
        }
        .on {
            color: #38a169;
            font-weight: bold;
        }
        .off {
            color: #e53e3e;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .brightness-bar {
            height: 10px;
            background-color: #edf2f7;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 5px;
        }
        .brightness-fill {
            height: 100%;
            background-color: #4299e1;
        }
    </style>
</head>
<body>
    <h1>Smart Lights Report</h1>
    <div class="header-info">
        <p>Generated on: {{ date('F d, Y h:i A') }}</p>
        @if(request('search') || request('status') || request('location'))
            <p>
                Filters applied:
                @if(request('search'))
                    Search: "{{ request('search') }}"
                @endif
                @if(request('status'))
                    Status: {{ request('status') }}
                @endif
                @if(request('location'))
                    Location: {{ request('location') }}
                @endif
            </p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Location</th>
                <th>Brightness</th>
                <th>Last Updated</th>
            </tr>
        </thead>
        <tbody>
            @forelse($smartLights as $light)
                <tr>
                    <td>{{ $light->id }}</td>
                    <td>{{ $light->name }}</td>
                    <td class="{{ $light->status == 'On' ? 'on' : 'off' }}">{{ $light->status }}</td>
                    <td>{{ $light->location }}</td>
                    <td>
                        {{ $light->brightness }}%
                        <div class="brightness-bar">
                            <div class="brightness-fill" style="width: {{ $light->brightness }}%"></div>
                        </div>
                    </td>
                    <td>{{ $light->updated_at->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">No smart lights found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Smart Light Management System &copy; {{ date('Y') }}</p>
    </div>
</body>
</html>