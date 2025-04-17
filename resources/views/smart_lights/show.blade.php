<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Light Details</title>
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
        .card {
            background-color: #2d3748;
            border: none;
        }
        .btn-primary {
            background-color: #4299e1;
            border-color: #4299e1;
        }
        .btn-secondary {
            background-color: #718096;
            border-color: #718096;
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
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4>Smart Light Details</h4>
                            <a href="{{ route('smart-lights.index') }}" class="btn btn-secondary btn-sm">Back to Dashboard</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="text-info">{{ $smartLight->name }}</h5>
                            <hr>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Status:</strong>
                            </div>
                            <div class="col-md-8">
                                <span class="{{ $smartLight->status == 'On' ? 'status-on' : 'status-off' }}">
                                    {{ $smartLight->status }}
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Location:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $smartLight->location }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Brightness:</strong>
                            </div>
                            <div class="col-md-8">
                                <div class="d-flex align-items-center">
                                    <div class="me-2">{{ $smartLight->brightness }}%</div>
                                    <div class="progress flex-grow-1" style="height: 8px;">
                                        <div class="progress-bar bg-info" role="progressbar" 
                                            style="width: {{ $smartLight->brightness }}%" 
                                            aria-valuenow="{{ $smartLight->brightness }}" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Created at:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $smartLight->created_at->format('F d, Y h:i A') }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Last Updated:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $smartLight->updated_at->format('F d, Y h:i A') }}
                            </div>
                        </div>

                        <div class="d-flex mt-4 gap-2">
                            <a href="{{ route('smart-lights.edit', $smartLight->id) }}" class="btn btn-primary">
                                Edit Smart Light
                            </a>

                            <form action="{{ route('smart-lights.toggle', $smartLight->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-{{ $smartLight->status == 'On' ? 'warning' : 'success' }}">
                                    {{ $smartLight->status == 'On' ? 'Turn Off' : 'Turn On' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>