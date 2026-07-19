@extends((auth()->check() && auth()->user()->isAdmin()) ? 'layouts.admin' : 'layouts.app')

@section('title', 'Permintaan Surat')
@section('page_title', 'Permintaan Surat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Permintaan Surat</li>
@endsection

@section('content')
@if(auth()->check() && auth()->user()->isAdmin())
    <div class="row mb-4">
        <div class="col-12">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createLetterModal">
                <i class="fas fa-plus"></i> Buat Permintaan
            </button>
        </div>
    </div>
@else
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <h1>Permintaan Surat</h1>
                <p class="text-muted">Kelola permintaan surat warga</p>
            </div>
            <div class="col-md-4 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createLetterModal">
                    <i class="bi bi-plus-lg"></i> Buat Permintaan
                </button>
            </div>
        </div>
@endif

@if ($message = Session::get('success'))
    @if(auth()->check() && auth()->user()->isAdmin())
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @else
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
@endif

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Nama Pemohon</th>
                    <th>Jenis Surat</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Siap Diambil</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($letters as $letter)
                <tr>
                    <td><strong>{{ $letter->applicant_name }}</strong></td>
                    <td>{{ $letter->category->name ?? '-' }}</td>
                    <td>
                        @if(auth()->check() && auth()->user()->isAdmin())
                            <span class="badge badge-{{
                                $letter->status === 'diambil' ? 'success' :
                                ($letter->status === 'siap_diambil' ? 'info' :
                                ($letter->status === 'diproses' ? 'warning' :
                                ($letter->status === 'ditolak' ? 'danger' : 'secondary')))
                            }}">
                                {{ ucfirst(str_replace('_', ' ', $letter->status)) }}
                            </span>
                        @else
                            <span class="badge bg-{{
                                $letter->status === 'diambil' ? 'success' :
                                ($letter->status === 'siap_diambil' ? 'info' :
                                ($letter->status === 'diproses' ? 'warning' :
                                ($letter->status === 'ditolak' ? 'danger' : 'secondary')))
                            }}">
                                {{ ucfirst(str_replace('_', ' ', $letter->status)) }}
                            </span>
                        @endif
                    </td>
                    <td>{{ $letter->created_at->format('d M Y') }}</td>
                    <td>{{ $letter->ready_at ? $letter->ready_at->format('d M Y') : '-' }}</td>
                    <td>
                        @if(auth()->check() && auth()->user()->isAdmin())
                            <a href="{{ route('admin.letters.show', $letter) }}" class="btn btn-xs btn-info btn-outline-info">
                                Lihat
                            </a>
                            <a href="{{ route('admin.letters.edit', $letter) }}" class="btn btn-xs btn-warning btn-outline-warning">
                                Edit
                            </a>
                        @else
                            <button type="button" class="btn btn-xs btn-info btn-outline-info" data-bs-toggle="modal" data-bs-target="#letterDetailModal{{ $letter->id }}">
                                Lihat
                            </button>
                            <form action="{{ route('letters.destroy', $letter) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus permintaan surat ini?')">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        @if(auth()->check() && auth()->user()->isAdmin())
                            <i class="fas fa-inbox"></i>
                        @else
                            <i class="bi bi-inbox"></i>
                        @endif
                        Tidak ada permintaan surat
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-light">
        {{ $letters->links((auth()->check() && auth()->user()->isAdmin()) ? 'pagination::default' : 'pagination::bootstrap-5') }}
    </div>
</div>

@if(!(auth()->check() && auth()->user()->isAdmin()))
<!-- Modals untuk Detail Surat User -->
@foreach ($letters as $letter)
<div class="modal fade" id="letterDetailModal{{ $letter->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Permintaan Surat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nama Pemohon</strong>
                        <p>{{ $letter->applicant_name ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>NIK</strong>
                        <p>{{ $letter->applicant_nik ?? '-' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Jenis Surat</strong>
                        <p>{{ $letter->category->name ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal Dibuat</strong>
                        <p>{{ $letter->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Status</strong>
                        <p>
                            <span class="badge bg-{{
                                $letter->status === 'diambil' ? 'success' :
                                ($letter->status === 'siap_diambil' ? 'info' :
                                ($letter->status === 'diproses' ? 'warning' :
                                ($letter->status === 'ditolak' ? 'danger' : 'secondary')))
                            }}">
                                {{ ucfirst(str_replace('_', ' ', $letter->status)) }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Tujuan Penggunaan</strong>
                    <p>{{ $letter->purpose }}</p>
                </div>

                @if($letter->notes)
                <div class="mb-3">
                    <strong>Catatan</strong>
                    <p>{{ $letter->notes }}</p>
                </div>
                @endif

                @if($letter->ready_at)
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Siap Diambil</strong>
                        <p>{{ $letter->ready_at->format('d M Y H:i') }}</p>
                    </div>
                    @if($letter->taken_at)
                    <div class="col-md-6">
                        <strong>Tanggal Diambil</strong>
                        <p>{{ $letter->taken_at->format('d M Y H:i') }}</p>
                    </div>
                    @endif
                </div>
                @endif

                @if($letter->identity_image)
                <div class="mb-3">
                    <strong>Foto KTP/KK</strong>
                    <div class="card border-light mt-2">
                        <div class="card-body p-2">
                            <img src="{{ asset('storage/' . $letter->identity_image) }}" alt="KTP/KK" class="img-fluid rounded" style="max-width: 100%; max-height: 400px; object-fit: contain;">
                        </div>
                    </div>
                </div>
                @endif

                @if($letter->letter_file)
                <div class="mb-3">
                    <strong>File Surat</strong>
                    <p>
                        <a href="{{ asset('storage/' . $letter->letter_file) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                            <i class="bi bi-download"></i> Download PDF
                        </a>
                    </p>
                </div>
                @endif

                @if($letter->admin_notes)
                <div class="alert alert-info mb-0">
                    <strong>Catatan Admin:</strong>
                    <p class="mb-0">{{ $letter->admin_notes }}</p>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif

@include('letters.partials.create-modal')
@endsection
