<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Light Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        .btn-pdf {
            background-color: #ed8936;
            border-color: #ed8936;
            color: white;
        }
        .btn-pdf:hover {
            background-color: #dd6b20;
            border-color: #dd6b20;
            color: white;
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
        .form-control, .form-select {
            background-color: #4a5568;
            border-color: #4a5568;
            color: #e2e8f0;
        }
        .form-control:focus, .form-select:focus {
            background-color: #4a5568;
            border-color: #63b3ed;
            color: #e2e8f0;
            box-shadow: 0 0 0 0.25rem rgba(99, 179, 237, 0.25);
        }
        .pagination {
            --bs-pagination-color: #e2e8f0;
            --bs-pagination-bg: #2d3748;
            --bs-pagination-border-color: #4a5568;
            --bs-pagination-hover-color: #e2e8f0;
            --bs-pagination-hover-bg: #4a5568;
            --bs-pagination-hover-border-color: #4a5568;
            --bs-pagination-focus-color: #e2e8f0;
            --bs-pagination-focus-bg: #4a5568;
            --bs-pagination-active-bg: #4299e1;
            --bs-pagination-active-border-color: #4299e1;
            --bs-pagination-disabled-color: #9fa6b2;
            --bs-pagination-disabled-bg: #2d3748;
            --bs-pagination-disabled-border-color: #4a5568;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark mb-4">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Smart Light Dashboard</span>
            <div>
                <a href="{{ route('smart-lights.create') }}" class="btn btn-success btn-sm me-2">
                    <i class="fas fa-plus"></i> Add New Light
                </a>
                <a href="{{ route('smart-lights.pdf') }}" class="btn btn-pdf btn-sm" id="export-pdf">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
            </div>
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

                <!-- Search and filter section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ route('smart-lights.index') }}" method="GET" class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search by name or location" 
                                           name="search" value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">-- Filter by Status --</option>
                                    <option value="On" {{ request('status') == 'On' ? 'selected' : '' }}>On</option>
                                    <option value="Off" {{ request('status') == 'Off' ? 'selected' : '' }}>Off</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="location" class="form-select">
                                    <option value="">-- Filter by Location --</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                            {{ $location }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                                    <a href="{{ route('smart-lights.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

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
                        
                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $smartLights->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('export-pdf').addEventListener('click', function(e) {
            e.preventDefault();
            let url = this.getAttribute('href');
            
            // Append current filter parameters to PDF URL
            const searchParams = new URLSearchParams(window.location.search);
            if (searchParams.toString()) {
                url += '?' + searchParams.toString();
            }
            
            window.location.href = url;
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>