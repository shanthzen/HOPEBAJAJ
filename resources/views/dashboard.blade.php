@extends('layouts.app')

@section('title', 'Student Management System ')

@push('styles')
<style>
    /* Dashboard Container */
    .dashboard-container {
        padding: 2rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: calc(100vh - 60px);
    }
    
    /* Card Base Styles */
    .dashboard-container .card {
        border: none !important;
        border-radius: 1.5rem !important;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05), 
                    inset 0 -2px 0 rgba(0, 0, 0, 0.1) !important;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
        overflow: hidden !important;
        margin-bottom: 1rem !important;
        backdrop-filter: blur(10px) !important;
        position: relative !important;
    }
    
    .dashboard-container .card::before {
        content: '' !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background: linear-gradient(45deg, transparent 0%, rgba(255, 255, 255, 0.1) 100%) !important;
        pointer-events: none !important;
    }
    
    .dashboard-container .card:hover {
        transform: translateY(-5px) !important;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1),
                    inset 0 -2px 0 rgba(0, 0, 0, 0.1) !important;
    }
    
    /* Modern Cards */
    .dashboard-container .card.bg-primary {
        background: #2563eb !important;
        border-left: 5px solid #60a5fa !important;
    }
    
    .dashboard-container .card.bg-success {
        background: #16a34a !important;
        border-left: 5px solid #4ade80 !important;
    }
    
    .dashboard-container .card.bg-purple {
        background: #7c3aed !important;
        border-left: 5px solid #a78bfa !important;
    }
    
    .dashboard-container .card.bg-orange {
        background: #ea580c !important;
        border-left: 5px solid #fb923c !important;
    }

    /* Card Hover Effects */
    .dashboard-container .card:hover {
        transform: translateY(-5px) !important;
    }
    
    .dashboard-container .card.bg-primary:hover {
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3) !important;
    }
    
    .dashboard-container .card.bg-success:hover {
        box-shadow: 0 8px 25px rgba(22, 163, 74, 0.3) !important;
    }
    
    .dashboard-container .card.bg-purple:hover {
        box-shadow: 0 8px 25px rgba(124, 58, 237, 0.3) !important;
    }
    
    .dashboard-container .card.bg-orange:hover {
        box-shadow: 0 8px 25px rgba(234, 88, 12, 0.3) !important;
    }
    
    /* Enhanced Icon Styles */
    .dashboard-container .square-icon {
        width: 65px !important;
        height: 65px !important;
        background: rgba(255, 255, 255, 0.15) !important;
        backdrop-filter: blur(10px) !important;
        border-radius: 20px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        position: relative !important;
        overflow: hidden !important;
        border: 2px solid rgba(255, 255, 255, 0.1) !important;
    }

    .dashboard-container .square-icon i {
        transition: all 0.3s ease !important;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2)) !important;
    }

    .dashboard-container .card:hover .square-icon i {
        transform: scale(1.2) !important;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3)) !important;
    }

    .dashboard-container .square-icon::before {
        content: '' !important;
        position: absolute !important;
        top: 0 !important;
        left: -100% !important;
        width: 100% !important;
        height: 100% !important;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.2),
            transparent
        ) !important;
        transition: 0.5s !important;
    }

    .dashboard-container .card:hover .square-icon::before {
        left: 100% !important;
    }

    .dashboard-container .card:hover .square-icon {
        transform: scale(1.1) rotate(5deg) !important;
    }
    
    /* Card Content Styles */
    .dashboard-container .card-body {
        padding: 1.75rem !important;
    }
    
    .dashboard-container .card-subtitle {
        font-size: 0.9rem !important;
        letter-spacing: 1.2px !important;
        text-transform: uppercase !important;
        font-weight: 700 !important;
        margin-bottom: 0.75rem !important;
        position: relative !important;
        display: inline-block !important;
        padding-bottom: 8px !important;
    }

    /* Card Text Colors */
    .dashboard-container .card-subtitle {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    .dashboard-container .card-value {
        color: #ffffff !important;
        font-weight: 700 !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    }

    .dashboard-container .card-subtitle::after {
        content: '' !important;
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        width: 40px !important;
        height: 3px !important;
        background: rgba(255, 255, 255, 0.3) !important;
        border-radius: 3px !important;
    }
    
    .dashboard-container .card-value {
        font-size: 2.75rem !important;
        font-weight: 800 !important;
        margin-bottom: 0 !important;
        letter-spacing: -0.5px !important;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2) !important;
        font-family: 'Arial', sans-serif !important;
        position: relative !important;
        display: inline-block !important;
        padding: 5px 0 !important;
        transition: transform 0.3s ease !important;
    }

    /* Square Icon Colors */
    .dashboard-container .square-icon {
        background: rgba(255, 255, 255, 0.2) !important;
        border: none !important;
    }

    .dashboard-container .square-icon i {
        color: #ffffff !important;
    }

    .dashboard-container .card-value::after {
        content: '' !important;
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 2px !important;
        background: rgba(255, 255, 255, 0.2) !important;
        border-radius: 2px !important;
    }

    .dashboard-container .card:hover .card-value {
        transform: scale(1.05) !important;
    }
    
    /* Enhanced Table Styles */
    .dashboard-container .table-card {
        background: white !important;
        border-radius: 1.5rem !important;
        overflow: hidden !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05),
                    inset 0 -2px 0 rgba(0, 0, 0, 0.05) !important;
        transition: all 0.3s ease !important;
    }

    .dashboard-container .table-card:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1),
                    inset 0 -2px 0 rgba(0, 0, 0, 0.05) !important;
        transform: translateY(-3px) !important;
    }
    
    .dashboard-container .table {
        margin-bottom: 0 !important;
    }
    
    .dashboard-container .table thead th {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
        color: #1e293b !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        font-size: 0.875rem !important;
        letter-spacing: 0.8px !important;
        padding: 1.25rem 1.5rem !important;
        border-bottom: 2px solid rgba(0, 0, 0, 0.05) !important;
        position: relative !important;
    }

    .dashboard-container .table thead th::after {
        content: '' !important;
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 1px !important;
        background: linear-gradient(to right, transparent, rgba(0, 0, 0, 0.1), transparent) !important;
    }
    
    .dashboard-container .table tbody td {
        padding: 1.25rem 1.5rem !important;
        color: #334155 !important;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
        vertical-align: middle !important;
        font-weight: 500 !important;
        transition: all 0.3s ease !important;
    }

    .dashboard-container .table tbody tr {
        transition: all 0.3s ease !important;
    }

    .dashboard-container .table tbody tr:hover {
        background-color: #f8fafc !important;
        transform: translateX(5px) !important;
    }

    .dashboard-container .table tbody tr:hover td {
        color: #1e293b !important;
    }

    .dashboard-container .table tbody tr:hover i {
        transform: scale(1.1) !important;
        color: #4338CA !important;
    }
    
    /* Enhanced Chart Card */
    .dashboard-container .chart-card {
        background: white !important;
        border-radius: 1.5rem !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05),
                    inset 0 -2px 0 rgba(0, 0, 0, 0.05) !important;
        margin-bottom: 2rem !important;
        overflow: hidden !important;
        height: 550px !important;
        transition: all 0.3s ease !important;
        position: relative !important;
    }

    .dashboard-container .chart-card:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1),
                    inset 0 -2px 0 rgba(0, 0, 0, 0.05) !important;
        transform: translateY(-5px) !important;
    }

    .dashboard-container .chart-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
        border-bottom: none !important;
        padding: 1.5rem 2rem !important;
        position: relative !important;
    }

    .dashboard-container .chart-card .card-header::after {
        content: '' !important;
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 1px !important;
        background: linear-gradient(to right, transparent, rgba(0, 0, 0, 0.1), transparent) !important;
    }

    .dashboard-container .chart-card .card-header h5 {
        color: #1e293b !important;
        font-weight: 700 !important;
        font-size: 1.25rem !important;
        margin: 0 !important;
        letter-spacing: -0.5px !important;
        display: flex !important;
        align-items: center !important;
    }

    .dashboard-container .chart-card .card-header h5 i {
        margin-right: 0.75rem !important;
        font-size: 1.1em !important;
        background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        filter: drop-shadow(0 2px 4px rgba(79, 70, 229, 0.2)) !important;
    }

    .dashboard-container .chart-card .card-body {
        padding: 2rem !important;
        height: calc(100% - 70px) !important;
        background: linear-gradient(180deg, white 0%, #f8fafc 100%) !important;
    }

    /* Progress Bar Styles */
    .progress {
        height: 12px !important;
        border-radius: 8px !important;
        overflow: hidden !important;
        background-color: #f1f5f9 !important;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05) !important;
        position: relative !important;
    }

    .progress::after {
        content: '' !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background: linear-gradient(90deg, 
            transparent 0%,
            rgba(255, 255, 255, 0.2) 50%,
            transparent 100%
        ) !important;
        pointer-events: none !important;
    }

    .progress-bar {
        background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%) !important;
        box-shadow: 0 2px 4px rgba(79, 70, 229, 0.3) !important;
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1) !important;
        position: relative !important;
        overflow: hidden !important;
        color: white !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-width: 2rem !important;
    }

    .progress-bar::before {
        content: '' !important;
        position: absolute !important;
        top: 0 !important;
        left: -100% !important;
        width: 100% !important;
        height: 100% !important;
        background: linear-gradient(
            90deg,
            transparent 0%,
            rgba(255, 255, 255, 0.2) 50%,
            transparent 100%
        ) !important;
        animation: progressShine 2s infinite !important;
    }

    @keyframes progressShine {
        100% {
            left: 100% !important;
        }
    }

    /* Empty State Styles */
    .text-center.text-muted {
        padding: 3rem !important;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
        border-radius: 1rem !important;
        font-size: 1.1rem !important;
        color: #64748b !important;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05) !important;
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
        margin: 1.5rem !important;
        position: relative !important;
        overflow: hidden !important;
    }

    .text-center.text-muted::before {
        content: '' !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background: linear-gradient(45deg, transparent 0%, rgba(255, 255, 255, 0.5) 100%) !important;
        pointer-events: none !important;
    }

    .text-center.text-muted i {
        font-size: 2rem !important;
        color: #94a3b8 !important;
        margin-bottom: 1rem !important;
        display: block !important;
        opacity: 0.5 !important;
    }
    
    /* Responsive styles */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem !important;
        }

        .dashboard-container .card-value {
            font-size: 1.75rem !important;
        }
        
        .dashboard-container .square-icon {
            width: 50px !important;
            height: 50px !important;
        }

        .dashboard-container .table thead th,
        .dashboard-container .table tbody td {
            padding: 1rem !important;
        }

        .dashboard-container .chart-card {
            height: 400px !important;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid dashboard-container">
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card text-white h-100" style="background-color: #0066cc !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2 card-subtitle">Student Enrollment</h6>
                            <h2 class="mb-0 card-value">{{ $totalStudents }}</h2>
                        </div>
                        <div class="square-icon">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white h-100" style="background-color: #00cc66 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2 card-subtitle">Certified Graduates</h6>
                            <h2 class="mb-0 card-value">{{ $totalGraduates }}</h2>
                        </div>
                        <div class="square-icon">
                            <i class="fas fa-graduation-cap fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white h-100" style="background-color: #9933ff !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2 card-subtitle">Career Placements</h6>
                            <h2 class="mb-0 card-value">{{ $totalPlacements }}</h2>
                        </div>
                        <div class="square-icon">
                            <i class="fas fa-briefcase fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white h-100" style="background-color: #ff6600 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2 card-subtitle">Average Package (LPA)</h6>
                            <h2 class="mb-0 card-value">{{ number_format($averageSalary / 100000, 2) }}</h2>
                        </div>
                        <div class="square-icon">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overview Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="chart-card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>
                        6-Month Overview
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="overviewChart" style="width: 100%; height: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Section -->
    <div class="row g-4">
        <!-- Recent Enrollments -->
        <div class="col-xl-6">
            <div class="table-card h-100">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-plus me-2 text-success"></i>
                        Recent Enrollments
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($recentStudents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Course</th>
                                        <th>Enrolled On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentStudents as $student)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-user-circle me-2 text-primary"></i>
                                                    {{ $student->full_name }}
                                                </div>
                                            </td>
                                            <td>{{ $student->course_enrolled }}</td>
                                            <td>{{ $student->enrollment_date?->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted my-4">
                            <i class="fas fa-user-graduate"></i>
                            No recent student enrollments to display
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Placements -->
        <div class="col-xl-6">
            <div class="table-card h-100">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-briefcase me-2 text-warning"></i>
                        Recent Placements
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($recentPlacements->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Package (LPA)</th>
                                        <th>Joined On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentPlacements as $placement)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-user-tie me-2 text-primary"></i>
                                                    {{ $placement->name }}
                                                </div>
                                            </td>
                                            <td>{{ $placement->company_name }}</td>
                                            <td>₹{{ $placement->salary }}</td>
                                            <td>{{ $placement->joining_date->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted my-4">
                            <i class="fas fa-briefcase"></i>
                            No recent placements to display
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Overview Chart
    new Chart(document.getElementById('overviewChart'), {
        type: 'bar',
        data: {
            labels: @json($monthlyStats['labels']),
            datasets: [
                {
                    label: 'Students',
                    data: @json($monthlyStats['students']),
                    backgroundColor: '#4F46E5',
                    barPercentage: 0.7,
                    categoryPercentage: 0.8
                },
                {
                    label: 'Graduates',
                    data: @json($monthlyStats['graduates']),
                    backgroundColor: '#059669',
                    barPercentage: 0.7,
                    categoryPercentage: 0.8
                },
                {
                    label: 'Placements',
                    data: @json($monthlyStats['placements']),
                    backgroundColor: '#8B5CF6',
                    barPercentage: 0.7,
                    categoryPercentage: 0.8
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: 15
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f5f9'
                    },
                    ticks: {
                        display: false,
                        stepSize: 1
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#475569',
                        font: {
                            size: 12
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        color: '#475569',
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
</script>
@endpush

@endsection
