<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Light Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-color: #151a2f;
            --card-bg: #1c2240;
            --text-color: #f8f9fa;
            --accent-color: #3498db;
            --success-color: #2ecc71;
            --warning-color: #e74c3c;
            --border-color: #2c3e50;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .search-bar {
            width: 100%;
            padding: 0.7rem 1rem;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            color: var(--text-color);
            margin: 1rem 0;
        }

        .btn-action {
            padding: 0.55rem 1.25rem;
            border-radius: 50px;
            font-weight: 500;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-add {
            background-color: var(--success-color);
            color: white;
        }

        .btn-pdf {
            background-color: #6c5ce7;
            color: white;
        }

        .filter-container {
            display: flex;
            gap: 10px;
            margin-bottom: 1.5rem;
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            color: var(--text-color);
            font-size: 0.9rem;
        }

        .filter-btn.active {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .dropdown-menu-dark {
            background-color: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 0.5rem;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            margin-top: 0.5rem;
        }

        .dropdown-item {
            color: var(--text-color);
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .dropdown-item:hover, .dropdown-item:focus {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text-color);
        }

        .dropdown-item.active {
            background-color: var(--accent-color);
            color: white;
        }

        .dropdown-toggle::after {
            margin-left: 0.5rem;
            vertical-align: middle;
        }

        .lights-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
        }

        .lights-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .lights-table td {
            padding: 1rem;
            vertical-align: middle;
        }

        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .status-on {
            color: var(--success-color);
        }

        .status-off {
            color: var(--warning-color);
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-dot.on {
            background-color: var(--success-color);
        }

        .status-dot.off {
            background-color: var(--warning-color);
        }

        .brightness-bar {
            height: 8px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            overflow: hidden;
            width: 100%;
            max-width: 200px;
        }

        .brightness-progress {
            height: 100%;
            background-color: var(--accent-color);
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text-color);
            border: none;
            margin-right: 5px;
        }

        .action-btn.power-on {
            color: var(--success-color);
        }
        
        .action-btn.power-off {
            color: var(--text-color);
        }

        .action-btn.edit {
            color: var(--accent-color);
        }

        .action-btn.delete {
            color: var(--warning-color);
        }

        .pagination-container {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            gap: 5px;
        }

        .page-item {
            width: 36px;
            height: 36px;
        }

        .page-link {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text-color);
            text-decoration: none;
        }

        .page-item.active .page-link {
            background-color: var(--accent-color);
        }

        .results-info {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
            text-align: center;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>Smart Light Dashboard</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('smart-lights.create') }}" class="btn-action btn-add">
                    <i class="fas fa-plus"></i> Add New Light
                </a>
                <a href="{{ route('smart-lights.pdf') }}" class="btn-action btn-pdf" id="export-pdf">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Search bar -->
        <form action="{{ route('smart-lights.index') }}" method="GET">
            <div class="d-flex gap-3 mb-4">
                <input type="text" class="search-bar" name="search" placeholder="Search lights..." value="{{ request('search') }}">
                <button type="submit" hidden>Search</button>
            </div>

            <!-- Filter section -->
            <div class="filter-container">
                <div class="dropdown">
                    <button class="filter-btn dropdown-toggle" type="button" id="locationFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ request('location') ?: 'All Locations' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="locationFilterDropdown">
                        <li><a class="dropdown-item {{ !request('location') ? 'active' : '' }}" href="{{ route('smart-lights.index', array_merge(request()->except('location', 'page'), ['location' => ''])) }}">All Locations</a></li>
                        @foreach($locations as $location)
                            <li><a class="dropdown-item {{ request('location') == $location ? 'active' : '' }}" 
                                  href="{{ route('smart-lights.index', array_merge(request()->except('location', 'page'), ['location' => $location])) }}">{{ $location }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="filter-btn dropdown-toggle" type="button" id="statusFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ request('status') ?: 'All Status' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="statusFilterDropdown">
                        <li><a class="dropdown-item {{ !request('status') ? 'active' : '' }}" href="{{ route('smart-lights.index', array_merge(request()->except('status', 'page'), ['status' => ''])) }}">All Status</a></li>
                        <li><a class="dropdown-item {{ request('status') == 'On' ? 'active' : '' }}" 
                              href="{{ route('smart-lights.index', array_merge(request()->except('status', 'page'), ['status' => 'On'])) }}">On</a></li>
                        <li><a class="dropdown-item {{ request('status') == 'Off' ? 'active' : '' }}" 
                              href="{{ route('smart-lights.index', array_merge(request()->except('status', 'page'), ['status' => 'Off'])) }}">Off</a></li>
                    </ul>
                </div>

                @if(request('search') || request('status') || request('location'))
                    <a href="{{ route('smart-lights.index') }}" class="filter-btn">
                        <i class="fas fa-times-circle me-1"></i> Clear Filters
                    </a>
                @endif
            </div>
        </form>

        <table class="lights-table">
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>STATUS</th>
                    <th>LOCATION</th>
                    <th>BRIGHTNESS</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @if(count($smartLights) > 0)
                    @foreach($smartLights as $light)
                    <tr>
                        <td>{{ $light->name }}</td>
                        <td>
                            <span class="status-indicator {{ $light->status == 'On' ? 'status-on' : 'status-off' }}">
                                <span class="status-dot {{ strtolower($light->status) }}"></span>
                                {{ $light->status }}
                            </span>
                        </td>
                        <td>{{ $light->location }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="brightness-bar">
                                    <div class="brightness-progress" style="width: {{ $light->brightness }}%"></div>
                                </div>
                                <span>{{ $light->brightness }}%</span>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex;">
                                <form action="{{ route('smart-lights.toggle', $light->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="action-btn {{ $light->status == 'On' ? 'power-on' : 'power-off' }}">
                                        <i class="fas fa-power-off"></i>
                                    </button>
                                </form>
                                <a href="{{ route('smart-lights.edit', $light->id) }}" class="action-btn edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('smart-lights.destroy', $light->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" 
                                        onclick="return confirm('Are you sure you want to delete this light?')">
                                        <i class="fas fa-trash"></i>
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

        <div class="pagination-container">
            {{ $smartLights->withQueryString()->links() }}
        </div>

        <div class="results-info">
            Showing 1 to {{ min(5, count($smartLights)) }} of {{ $smartLights->total() }} results
        </div>
    </div>

    <script>
        // Export PDF with filters
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

        // Basic client-side filtering for demo purposes
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toUpperCase();
            let table = document.querySelector('.lights-table');
            let rows = table.getElementsByTagName('tr');
            
            for (let i = 1; i < rows.length; i++) {
                let found = false;
                let cells = rows[i].getElementsByTagName('td');
                
                for (let j = 0; j < cells.length; j++) {
                    let cell = cells[j];
                    if (cell) {
                        let textValue = cell.textContent || cell.innerText;
                        if (textValue.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
                
                rows[i].style.display = found ? '' : 'none';
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>