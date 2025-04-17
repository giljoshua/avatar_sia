<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Smart Light</title>
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
        .form-label {
            color: #e2e8f0;
        }
        .btn-primary {
            background-color: #4299e1;
            border-color: #4299e1;
        }
        .btn-secondary {
            background-color: #718096;
            border-color: #718096;
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
                            <h4>Add New Smart Light</h4>
                            <a href="{{ route('smart-lights.index') }}" class="btn btn-secondary btn-sm">Back to Dashboard</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Error!</strong> Please check the form fields.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('smart-lights.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Light Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter light name" value="{{ old('name') }}">
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" name="location" class="form-control" id="location" placeholder="Enter light location" value="{{ old('location') }}">
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Initial Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="Off" {{ old('status') == 'Off' ? 'selected' : '' }}>Off</option>
                                    <option value="On" {{ old('status') == 'On' ? 'selected' : '' }}>On</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="brightness" class="form-label">Brightness (0-100%)</label>
                                <div class="d-flex gap-2 align-items-center">
                                    <input type="range" name="brightness" class="form-range" min="0" max="100" step="5" id="brightness" value="{{ old('brightness', 100) }}" oninput="brightnessValue.innerText = this.value + '%'">
                                    <span id="brightnessValue" class="ms-2" style="min-width: 60px;">{{ old('brightness', 100) }}%</span>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Add Smart Light</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>