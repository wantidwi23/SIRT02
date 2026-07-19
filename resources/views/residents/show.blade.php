@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.app')

@section('title', 'Detail Data Warga')
@section('page_title', 'Detail Data Warga')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.residents.index') }}">Data Warga</a></li>
    <li class="breadcrumb-item active">{{ $resident->name }}</li>
@endsection

@section('content')
@if(auth()->user()->isAdmin())
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('admin.residents.edit', $resident) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.residents.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@else
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <h1>{{ $resident->name }}</h1>
                <p class="text-muted">Detail Data Warga</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('residents.edit', $resident) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('residents.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
@endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Pribadi</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Email</strong>
                            <p>{{ $resident->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Jenis Kelamin</strong>
                            <p>{{ $resident->gender ? ucfirst($resident->gender) : '-' }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Status</strong>
                            <p>
                                @if(auth()->user()->isAdmin())
                                    <span class="badge badge-{{ $resident->status === 'active' ? 'success' : 'warning' }}">
                                        {{ ucfirst($resident->status) }}
                                    </span>
                                @else
                                    <span class="badge bg-{{ $resident->status === 'active' ? 'success' : 'warning' }}">
                                        {{ ucfirst($resident->status) }}
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Alamat</strong>
                        <p>{{ $resident->address }}</p>
                    </div>
                </div>
            </div>

            @if($resident->notes)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Catatan</h5>
                </div>
                <div class="card-body">
                    <p>{{ $resident->notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Aktivitas</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        <small>
                            Dibuat: {{ $resident->created_at->format('d M Y H:i') }}<br>
                            Diupdate: {{ $resident->updated_at->format('d M Y H:i') }}
                        </small>
                    </p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Laporan ({{ $resident->reports->count() }})</h5>
                </div>
                <div class="card-body">
                    @forelse($resident->reports as $report)
                        <div class="mb-2">
                            <a href="{{ route('reports.show', $report) }}" class="text-decoration-none">
                                {{ $report->title }}
                            </a>
                            <br>
                            <small class="text-muted">
                                @if(auth()->user()->isAdmin())
                                    <span class="badge badge-{{
                                        $report->status === 'selesai' ? 'success' :
                                        ($report->status === 'diproses' ? 'warning' : 'secondary')
                                    }}">{{ ucfirst($report->status) }}</span>
                                @else
                                    <span class="badge bg-{{
                                        $report->status === 'selesai' ? 'success' :
                                        ($report->status === 'diproses' ? 'warning' : 'secondary')
                                    }}">{{ ucfirst($report->status) }}</span>
                                @endif
                            </small>
                        </div>
                    @empty
                        <p class="text-muted"><small>Tidak ada laporan</small></p>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Permintaan Surat ({{ $resident->letters->count() }})</h5>
                </div>
                <div class="card-body">
                    @forelse($resident->letters as $letter)
                        <div class="mb-2">
                            <a href="{{ route('letters.show', $letter) }}" class="text-decoration-none">
                                {{ ucfirst(str_replace('_', ' ', $letter->type)) }}
                            </a>
                            <br>
                            <small class="text-muted">
                                @if(auth()->user()->isAdmin())
                                    <span class="badge badge-{{
                                        $letter->status === 'diambil' ? 'success' :
                                        ($letter->status === 'siap_diambil' ? 'info' : 'secondary')
                                    }}">{{ ucfirst(str_replace('_', ' ', $letter->status)) }}</span>
                                @else
                                    <span class="badge bg-{{
                                        $letter->status === 'diambil' ? 'success' :
                                        ($letter->status === 'siap_diambil' ? 'info' : 'secondary')
                                    }}">{{ ucfirst(str_replace('_', ' ', $letter->status)) }}</span>
                                @endif
                            </small>
                        </div>
                    @empty
                        <p class="text-muted"><small>Tidak ada permintaan surat</small></p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <form action="{{ route('residents.destroy', $resident) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                @if(auth()->user()->isAdmin())
                    <i class="fas fa-trash"></i>
                @else
                    <i class="bi bi-trash"></i>
                @endif
                Hapus Data
            </button>
        </form>
    </div>

@if(!auth()->user()->isAdmin())
    </div>
@endif
@endsection
