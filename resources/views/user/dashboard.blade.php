@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <h1 class="dashboard-title">Dashboard Warga</h1>
                    @if (session('head_of_family_id'))
                        <p class="dashboard-subtitle">Selamat datang, <span class="fw-bold">{{ session('head_of_family_name') }}</span>!</p>
                    @else
                        <p class="dashboard-subtitle">Selamat datang, <span class="fw-bold">{{ auth()->user()->name }}</span>!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">

    <!-- Stats Row -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card stat-card-success">
                <div class="stat-card-content">
                    <div class="stat-label">Laporan Saya</div>
                    <div class="stat-value">
                        @php
                            $reportCount = 0;
                            if (session('head_of_family_id')) {
                                $reportCount = \App\Models\Report::where('head_of_family_id', session('head_of_family_id'))->count();
                            }
                            echo $reportCount;
                        @endphp
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card stat-card-warning">
                <div class="stat-card-content">
                    <div class="stat-label">Surat Saya</div>
                    <div class="stat-value">
                        @php
                            $letterCount = 0;
                            if (session('head_of_family_id')) {
                                $letterCount = \App\Models\Letter::where('head_of_family_id', session('head_of_family_id'))->count();
                            }
                            echo $letterCount;
                        @endphp
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card stat-card-info">
                <div class="stat-card-content">
                    <div class="stat-label">Anggaran Percakapan</div>
                    <div class="stat-value">Aktif</div>
                    <div class="stat-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row g-4">
        <div class="col-md-8">
            <div class="activity-card">
                <div class="activity-card-header">
                    <h5 class="activity-title">
                        <i class="fas fa-file-alt"></i>
                        Laporan Terbaru
                    </h5>
                </div>
                <div class="activity-card-body">
                    @php
                        $reports = collect();
                        
                        // If user is head_of_family, get reports by head_of_family_id
                        if (session('head_of_family_id')) {
                            $reports = \App\Models\Report::where('head_of_family_id', session('head_of_family_id'))
                                ->latest()
                                ->take(5)
                                ->get();
                        }
                    @endphp
                    @if ($reports->count() > 0)
                        @foreach($reports as $report)
                            <div class="activity-item">
                                <div class="activity-item-content">
                                    <h6 class="activity-item-title">{{ $report->title ?? 'Laporan Tanpa Judul' }}</h6>
                                    <p class="activity-item-date">{{ $report->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="activity-item-badge">
                                    <span class="badge-{{ $report->status === 'disetujui' ? 'success' : 'warning' }}">
                                        {{ ucfirst($report->status ?? 'Pending') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada laporan</p>
                        </div>
                    @endif
                </div>
                <div class="activity-card-footer">
                    <a href="{{ route('reports.index') }}" class="btn btn-modern btn-success">Lihat Semua Laporan <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="activity-card">
                <div class="activity-card-header">
                    <h5 class="activity-title">
                        <i class="fas fa-envelope"></i>
                        Surat Terbaru
                    </h5>
                </div>
                <div class="activity-card-body">
                    @php
                        $letters = collect();
                        
                        // If user is head_of_family, get letters by head_of_family_id
                        if (session('head_of_family_id')) {
                            $letters = \App\Models\Letter::where('head_of_family_id', session('head_of_family_id'))
                                ->latest()
                                ->take(3)
                                ->get();
                        }
                    @endphp
                    @if ($letters->count() > 0)
                        @foreach($letters as $letter)
                            <div class="activity-item">
                                <div class="activity-item-content">
                                    <h6 class="activity-item-title">{{ str_replace('_', ' ', ucfirst($letter->type ?? 'Surat')) }}</h6>
                                    <p class="activity-item-date">{{ $letter->created_at->format('d M Y') }}</p>
                                </div>
                                <div class="activity-item-badge">
                                    <span class="badge-{{ $letter->status === 'diambil' ? 'success' : 'warning' }}">
                                        {{ ucfirst(str_replace('_', ' ', $letter->status ?? 'Pending')) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada surat</p>
                        </div>
                    @endif
                </div>
                <div class="activity-card-footer">
                    <a href="{{ route('letters.index') }}" class="btn btn-modern btn-warning">Lihat Semua Surat <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --color-sage: #8ebfa3;
        --color-yellow: #fef3c7;
        --color-lime: #c6e48b;
        --color-olive: #9ca46d;
    }

  

    .dashboard-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .dashboard-subtitle {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }

    /* Stat Cards */
    .stat-card {
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        min-height: 160px;
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .stat-card-success {
        background: linear-gradient(135deg, #c6e48b 0%, #a8d657 100%);
        box-shadow: 0 4px 15px rgba(198, 228, 139, 0.2);
    }

    .stat-card-warning {
        background: linear-gradient(135deg, #fef3c7 0%, #fce8a8 100%);
        box-shadow: 0 4px 15px rgba(254, 243, 199, 0.2);
    }

    .stat-card-info {
        background: linear-gradient(135deg, #8ebfa3 0%, #7db898 100%);
        box-shadow: 0 4px 15px rgba(142, 191, 163, 0.2);
    }

    .stat-card-content {
        color: #2d3748;
        padding: 2rem;
        width: 100%;
        position: relative;
        z-index: 2;
    }

    .stat-label {
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.85;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 1rem;
    }

    .stat-icon {
        font-size: 3rem;
        opacity: 0.15;
        position: absolute;
        bottom: 1rem;
        right: 1.5rem;
    }

    /* Activity Cards */
    .activity-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .activity-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .activity-card-header {
        background: linear-gradient(135deg, #f0f8f4 0%, #e8f3f0 100%);
        padding: 1.5rem;
        border-bottom: 2px solid #e0ebe6;
    }

    .activity-title {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #2d3748;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .activity-title i {
        font-size: 1.25rem;
        color: #8ebfa3;
    }

    .activity-card-body {
        padding: 1.5rem;
        flex: 1;
        overflow-y: auto;
    }

    .activity-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        margin-bottom: 0.75rem;
        background: #f8faf9;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .activity-item:last-child {
        margin-bottom: 0;
    }

    .activity-item:hover {
        background: #e8f3f0;
        transform: translateX(5px);
    }

    .activity-item-content {
        flex: 1;
    }

    .activity-item-title {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.25rem;
    }

    .activity-item-date {
        margin: 0;
        font-size: 0.8rem;
        color: #9ca46d;
    }

    .activity-item-badge {
        margin-left: 1rem;
    }

    .badge-success {
        background: linear-gradient(135deg, #c6e48b 0%, #a8d657 100%);
        color: #3d5a2f;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-warning {
        background: linear-gradient(135deg, #fef3c7 0%, #fce8a8 100%);
        color: #78581f;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
    }

    .empty-state i {
        font-size: 3rem;
        color: #cbd5e0;
        margin-bottom: 1rem;
        display: block;
    }

    .empty-state p {
        color: #a0aec0;
        margin: 0;
        font-size: 0.95rem;
    }

    .activity-card-footer {
        padding: 1.5rem;
        border-top: 1px solid #e9ecef;
        background: #f8faf9;
    }

    /* Modern Buttons */
    .btn-modern {
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-success {
        background: linear-gradient(135deg, #c6e48b 0%, #a8d657 100%);
        color: #3d5a2f;
    }

    .btn-success:hover {
        color: #3d5a2f;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(198, 228, 139, 0.3);
    }

    .btn-warning {
        background: linear-gradient(135deg, #fef3c7 0%, #fce8a8 100%);
        color: #78581f;
    }

    .btn-warning:hover {
        color: #78581f;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(254, 243, 199, 0.3);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-title {
            font-size: 1.8rem;
        }

        .stat-value {
            font-size: 2rem;
        }

        .stat-card {
            min-height: 140px;
        }

        .dashboard-container {
            padding-bottom: 1rem;
        }
    }
</style>
@endsection
