<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Light Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a202c;
            color: #e2e8f0;
        }
        .navbar {
            background-color: #1a202c;
            border-bottom: 1px solid #2d3748;
        }
        .table {
            color: #e2e8f0;
        }
        .table thead th {
            background-color: #2d3748;
            color: #e2e8f0;
            border-color: #4a5568;
        }
        .table tbody td {
            border-color: #4a5568;
        }
        .card {
            background-color: #2d3748;
            border: none;
        }
        .btn-success {
            background-color: #48bb78;
            border-color: #48bb78;
        }
        .btn-danger {
            background-color: #f56565;
            border-color: #f56565;
        }
        .brightness-control {
            width: 100%;
        }
        .status-on {
            color: #48bb78;
            font-weight: bold;
        }
        .status-off {
            color: #f56565;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark mb-4">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Smart Light Dashboard</span>
            <a href="{{ route('smart-lights.create') }}" class="btn btn-success btn-sm">Add New Light</a>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Location</th>
                                        <th>Brightness</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($smartLights) > 0)
                                        @foreach($smartLights as $light)
                                        <tr>
                                            <td>{{ $light->name }}</td>
                                            <td>
                                                <span class="{{ $light->status == 'On' ? 'status-on' : 'status-off' }}">
                                                    {{ $light->status }}
                                                </span>
                                            </td>
                                            <td>{{ $light->location }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2">{{ $light->brightness }}%</div>
                                                    <div class="progress flex-grow-1" style="height: 8px;">
                                                        <div class="progress-bar bg-info" role="progressbar" 
                                                            style="width: {{ $light->brightness }}%" 
                                                            aria-valuenow="{{ $light->brightness }}" 
                                                            aria-valuemin="0" 
                                                            aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('smart-lights.edit', $light->id) }}" 
                                                        class="btn btn-primary btn-sm">
                                                        Edit
                                                    </a>
                                                    <!-- Updated Toggle Button -->
                                                    <form action="{{ route('smart-lights.toggle', $light->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-{{ $light->status == 'On' ? 'warning' : 'success' }} btn-sm">
                                                            {{ $light->status == 'On' ? 'Turn Off' : 'Turn On' }}
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('smart-lights.destroy', $light->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                                onclick="return confirm('Are you sure you want to delete this light?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">No smart lights found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>