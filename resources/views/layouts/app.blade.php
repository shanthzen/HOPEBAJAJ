<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HOPE Foundation') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('HOPE fevicon.png') }}" type="image/png">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 50px;
            --primary-color: #0066cc;    /* HOPE logo blue */
            --hover-color: #0052a3;      /* Darker blue */
            --accent-color: #e6f3ff;     /* Light blue */
            --bg-color: #f8fafc;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            
            --students-color: #0066cc;    /* Blue */
            --graduates-color: #059669;   /* Green */
            --placements-color: #7c3aed;  /* Purple */
            --data-mgmt-color: #dc2626;   /* Red */
            --user-mgmt-color: #d97706;   /* Orange */
        }
        
        body {
            background-color: var(--bg-color);
            font-family: "Nunito", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin-left: var(--sidebar-width);
            margin-top: calc(var(--header-height) + 1.5rem);
            padding: 1.5rem;
            color: var(--text-primary);
            height: 100vh;
            overflow-x: hidden;
        }
        
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .brand-section {
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 1.25rem;
            background-color: var(--primary-color);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .brand-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            text-decoration: none;
            letter-spacing: 0.5px;
        }

        .brand-name:hover {
            color: var(--accent-color);
            text-decoration: none;
        }

        .nav-menu {
            padding: 1rem;
            flex-grow: 1;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--primary-color) transparent;
        }
        
        .nav-menu::-webkit-scrollbar {
            width: 6px;
        }
        
        .nav-menu::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .nav-menu::-webkit-scrollbar-thumb {
            background-color: var(--primary-color);
            border-radius: 20px;
            border: 2px solid transparent;
        }
        
        .nav-item {
            margin-bottom: 0.5rem;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            font-weight: 500;
            position: relative;
            overflow: hidden;
            margin-bottom: 0.25rem;
        }

        .submenu {
            margin-left: 1rem;
            border-left: 1px dashed var(--border-color);
            margin-top: 0.25rem;
            margin-bottom: 0.25rem;
            padding-left: 0.5rem;
        }

        .submenu .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            opacity: 0.9;
            margin-bottom: 0.125rem;
        }

        .submenu .nav-link:hover {
            opacity: 1;
            background-color: var(--accent-color);
        }

        .submenu .nav-link i {
            font-size: 0.9rem;
        }

        .nav-link .fa-chevron-down {
            transition: transform 0.2s ease;
        }

        [aria-expanded="true"] .fa-chevron-down {
            transform: rotate(180deg);
        }

        .nav-link i {
            width: 24px;
            margin-right: 12px;
            font-size: 1rem;
            text-align: center;
            position: relative;
            z-index: 1;
        }
        
        .nav-link:hover {
            background-color: #f3f4f6;
            color: var(--primary-color);
            transform: translateX(4px);
        }
        
        .nav-link.active {
            background-color: var(--accent-color);
            color: var(--primary-color);
            transform: none;
            font-weight: 600;
            box-shadow: inset 4px 0 0 var(--primary-color);
        }

        .nav-link.active i {
            color: var(--primary-color);
        }

        /* Dashboard specific styles */
        .nav-item:first-child .nav-link {
            background: var(--accent-color);
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 102, 204, 0.1);
            padding: 1rem;
            border: 1px solid rgba(0, 102, 204, 0.1);
        }

        .nav-item:first-child .nav-link i {
            color: var(--primary-color);
            font-size: 1.2rem;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 8px;
            margin-right: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .nav-item:first-child .nav-link:hover {
            background: white;
            border-color: var(--primary-color);
            transform: translateY(-1px);
            box-shadow: 0 3px 6px rgba(0, 102, 204, 0.15);
        }

        .nav-item:first-child .nav-link:hover i {
            background: var(--accent-color);
            transform: scale(1.05);
        }

        .nav-item:first-child .nav-link.active {
            background: white;
            border-color: var(--primary-color);
            box-shadow: 0 3px 6px rgba(0, 102, 204, 0.15);
            transform: translateY(-1px);
        }

        .nav-item:first-child .nav-link.active i {
            background: var(--accent-color);
        }
        
        .nav-item.students-section .nav-link:hover,
        .nav-item.students-section .nav-link.active {
            background-color: rgba(37, 99, 235, 0.1);
            color: var(--students-color);
            border-left: 4px solid var(--students-color);
        }

        .nav-item.graduates-section .nav-link:hover,
        .nav-item.graduates-section .nav-link.active {
            background-color: rgba(5, 150, 105, 0.1);
            color: var(--graduates-color);
            border-left: 4px solid var(--graduates-color);
        }

        .nav-item.placements-section .nav-link:hover,
        .nav-item.placements-section .nav-link.active {
            background-color: rgba(124, 58, 237, 0.1);
            color: var(--placements-color);
            border-left: 4px solid var(--placements-color);
        }

        .nav-item.data-section .nav-link:hover,
        .nav-item.data-section .nav-link.active {
            background-color: rgba(220, 38, 38, 0.1);
            color: var(--data-mgmt-color);
            border-left: 4px solid var(--data-mgmt-color);
        }

        .nav-item.user-section .nav-link:hover,
        .nav-item.user-section .nav-link.active {
            background-color: rgba(217, 119, 6, 0.1);
            color: var(--user-mgmt-color);
            border-left: 4px solid var(--user-mgmt-color);
        }

        .nav-item.students-section .nav-link i {
            color: var(--students-color);
        }

        .nav-item.graduates-section .nav-link i {
            color: var(--graduates-color);
        }

        .nav-item.placements-section .nav-link i {
            color: var(--placements-color);
        }

        .nav-item.data-section .nav-link i {
            color: var(--data-mgmt-color);
        }

        .nav-item.user-section .nav-link i {
            color: var(--user-mgmt-color);
        }

        .main-header {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--header-height);
            background-color: var(--primary-color);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            z-index: 999;
        }

        .header-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            margin: 0;
        }

        .user-menu span {
            color: white;
            font-size: 0.9rem;
        }

        .user-menu {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid var(--border-color);
            background-color: white;
            flex-shrink: 0;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0.75rem;
            border: none;
            background-color: #fee2e2;
            color: #dc2626;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            background-color: #fecaca;
            transform: translateY(-2px);
        }

        .logout-btn i {
            margin-right: 8px;
        }
        
        .card {
            background: white;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background-color: white;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Table Styles */
        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            color: var(--text-primary);
            border-bottom-width: 1px;
        }

        .table td {
            vertical-align: middle;
            color: var(--text-secondary);
        }

        /* Form Styles */
        .form-control, .form-select {
            border-color: var(--border-color);
            padding: 0.5rem 0.75rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--hover-color);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        }

        .form-label {
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="brand-section">
            <a href="{{ url('/') }}" class="brand-name">HOPE Foundation</a>
        </div>
        
        <div class="nav-menu">
            <div class="nav-item students-section">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-tooltip="Overview Dashboard">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            
            <div class="nav-item students-section">
                <a href="#studentsMenu" class="nav-link" data-bs-toggle="collapse" role="button" data-tooltip="Manage Students">
                    <i class="fas fa-user-graduate"></i>
                    <span>Students</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse {{ request()->routeIs('students.*') ? 'show' : '' }} submenu" id="studentsMenu">
                    <a href="{{ route('students.index') }}" class="nav-link">
                        <i class="fas fa-list"></i>
                        <span>All Students</span>
                    </a>
                    <a href="{{ route('students.create') }}" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Student</span>
                    </a>
                </div>
            </div>
            
            <div class="nav-item graduates-section">
                <a href="#graduatesMenu" class="nav-link" data-bs-toggle="collapse" role="button" data-tooltip="Manage Graduates">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Graduates</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse {{ request()->routeIs('graduates.*') ? 'show' : '' }} submenu" id="graduatesMenu">
                    <a href="{{ route('graduates.index') }}" class="nav-link">
                        <i class="fas fa-list"></i>
                        <span>All Graduates</span>
                    </a>
                    <a href="{{ route('graduates.create') }}" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Graduate</span>
                    </a>
                </div>
            </div>
            
            <div class="nav-item placements-section">
                <a href="#placementsMenu" class="nav-link" data-bs-toggle="collapse" role="button" data-tooltip="Manage Placements">
                    <i class="fas fa-briefcase"></i>
                    <span>Placements</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse {{ request()->routeIs('placements.*') ? 'show' : '' }} submenu" id="placementsMenu">
                    <a href="{{ route('placements.index') }}" class="nav-link">
                        <i class="fas fa-list"></i>
                        <span>All Placements</span>
                    </a>
                    <a href="{{ route('placements.create') }}" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Placement</span>
                    </a>
                </div>
            </div>
            
            <div class="nav-item data-section">
                <a href="#dataManagement" class="nav-link" data-bs-toggle="collapse" role="button">
                    <i class="fas fa-database"></i>
                    <span>Data Management</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse {{ request()->routeIs('data-management') ? 'show' : '' }} submenu" id="dataManagement">
                    <a href="{{ route('data-management') }}" class="nav-link">
                        <i class="fas fa-chart-bar"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" onclick="exportData('students', 'pdf')" class="nav-link">
                        <i class="fas fa-file-export"></i>
                        <span>Export Students</span>
                    </a>
                    <a href="#" onclick="exportData('graduates', 'pdf')" class="nav-link">
                        <i class="fas fa-file-export"></i>
                        <span>Export Graduates</span>
                    </a>
                    <a href="#" onclick="exportData('placements', 'pdf')" class="nav-link">
                        <i class="fas fa-file-export"></i>
                        <span>Export Placements</span>
                    </a>
                </div>
            </div>
            
            <div class="nav-item user-section">
                <a href="{{ route('donors.index') }}" class="nav-link {{ request()->routeIs('donors.*') ? 'active' : '' }}" data-tooltip="View Donors">
                    <i class="fas fa-hands-helping"></i>
                    <span>Donors</span>
                </a>
            </div>
            
            @if(Auth::user()->isAdmin())
            <div class="nav-item user-section">
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" data-tooltip="Manage Users">
                    <i class="fas fa-users"></i>
                    <span>User Management</span>
                </a>
            </div>

            <div class="nav-item data-section">
                <a href="{{ route('activity-logs.index') }}" class="nav-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}" data-tooltip="View Activity Logs">
                    <i class="fas fa-history"></i>
                    <span>Activity Logs</span>
                </a>
            </div>
            @endif
        </div>
        
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-power-off"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <header class="main-header">
        <h1 class="header-title">Bajaj Finserv - HOPE Artificial Intelligence School for Girls</h1>
        <div class="user-menu">
            <div class="d-flex flex-column align-items-end">
                <span class="user-name text-white mb-1">{{ Auth::user()->name }}</span>
                <span class="user-role text-white-50" style="font-size: 0.8rem; text-transform: capitalize;">
                    {{ Auth::user()->role }}
                </span>
            </div>
        </div>
    </header>

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    @stack('scripts')
    @push('scripts')
    <script>
    function exportData(type, format) {
        // Show loading state
        Swal.fire({
            title: 'Exporting...',
            text: 'Please wait while we prepare your export',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Make the export request
        fetch(`/data/export/${type}?format=${format}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Start the download
                window.location.href = `/data/download/${data.export_id}`;
                
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message
                });
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Export Failed',
                text: error.message || 'An error occurred during export'
            });
        });
    }
    </script>
    @endpush
</body>
</html>
