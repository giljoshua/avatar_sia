<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Smart Light</title>
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
        .card-header h4 {
            color: #ffffff;
        }

        /* Authentication Dropdown Styles */
        .auth-dropdown {
            position: relative;
            display: inline-block;
        }

        .auth-dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background-color: #2d3748;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 5px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .auth-dropdown:hover .auth-dropdown-menu {
            display: block;
        }

        .auth-dropdown-menu a, .auth-dropdown-menu form button {
            color: #e2e8f0;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
            background: none;
            border: none;
            width: 100%;
            font-size: 0.9rem;
        }

        .auth-dropdown-menu a:hover, .auth-dropdown-menu form button:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .auth-divider {
            height: 1px;
            margin: 0.5rem 0;
            background-color: rgba(255,255,255,0.1);
        }

        .auth-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.7rem 1rem;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.2s;
        }

        .auth-user:hover {
            background-color: rgba(255,255,255,0.05);
        }

        .auth-user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #4299e1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }

        .auth-user-info {
            display: flex;
            flex-direction: column;
        }

        .auth-user-name {
            font-weight: 500;
        }

        .auth-user-email {
            font-size: 0.8rem;
            opacity: 0.7;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark mb-4">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Smart Light Dashboard</span>

            <!-- Authentication -->
            <div class="auth-dropdown">
                <div class="auth-user">
                    <div class="auth-user-avatar">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="auth-user-info d-none d-md-flex">
                        <span class="auth-user-name">{{ Auth::user()->name }}</span>
                        <span class="auth-user-email">{{ Auth::user()->email }}</span>
                    </div>
                </div>
                <div class="auth-dropdown-menu">
                    <a href="{{ route('smart-lights.index') }}">Dashboard</a>
                    <a href="{{ route('profile.edit') }}">Profile</a>
                    <div class="auth-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Log Out</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4>Edit Smart Light</h4>
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

                        <form action="{{ route('smart-lights.update', $smartLight->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Light Name</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{ $smartLight->name }}">
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" name="location" class="form-control" id="location" value="{{ $smartLight->location }}">
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="Off" {{ $smartLight->status == 'Off' ? 'selected' : '' }}>Off</option>
                                    <option value="On" {{ $smartLight->status == 'On' ? 'selected' : '' }}>On</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="brightness" class="form-label">Brightness (0-100%)</label>
                                <div class="d-flex gap-2 align-items-center">
                                    <input type="range" name="brightness" class="form-range" min="0" max="100" step="5" id="brightness" value="{{ $smartLight->brightness }}" oninput="brightnessValue.innerText = this.value + '%'">
                                    <span id="brightnessValue" class="ms-2" style="min-width: 60px; color: white">{{ $smartLight->brightness }}%</span>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Update Smart Light</button>
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