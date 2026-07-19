@extends('layouts.admin')

@section('title', 'Detail Permintaan Surat')
@section('page_title', 'Detail Permintaan Surat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.letters.index') }}">Permintaan Surat</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('admin.letters.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Detail Permintaan Surat</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Nama Warga/Pemohon</h6>
                        <p>
                            <strong>
                                @if($letter->resident)
                                    {{ $letter->resident->name }}
                                @else
                                    {{ $letter->applicant_name ?? '-' }}
                                @endif
                            </strong>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">NIK</h6>
                        <p>
                            <strong>
                                @if($letter->resident)
                                    {{ $letter->resident->nik }}
                                @else
                                    {{ $letter->applicant_nik ?? '-' }}
                                @endif
                            </strong>
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    @if($letter->resident)
                    <div class="col-md-6">
                        <h6 class="text-muted">Email</h6>
                        <p><strong>{{ $letter->resident->email }}</strong></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">No. Telepon</h6>
                        <p><strong>{{ $letter->resident->phone ?? '-' }}</strong></p>
                    </div>
                    @endif
                </div>

                <hr>

                <div class="mb-3">
                    <h6 class="text-muted">Jenis Surat</h6>
                    <p><strong>{{ $letter->category->name ?? '-' }}</strong></p>
                </div>

                <div class="mb-3">
                    <h6 class="text-muted">Tujuan Penggunaan</h6>
                    <p>{{ $letter->purpose }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="text-muted">Catatan Warga</h6>
                    <p>{{ $letter->notes ?? '<em class="text-muted">-</em>' }}</p>
                </div>

                <hr>

                @if($letter->identity_image)
                    <div class="mb-3">
                        <h6 class="text-muted">Foto KTP/KK</h6>
                        <div class="card border-light">
                            <div class="card-body p-2">
                                <img src="{{ asset('storage/' . $letter->identity_image) }}" alt="KTP/KK" class="img-fluid rounded" style="max-width: 100%; max-height: 500px; object-fit: contain;">
                            </div>
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <h6 class="text-muted">Catatan Admin</h6>
                    <p>{{ $letter->admin_notes ?? '<em class="text-muted">Belum ada catatan</em>' }}</p>
                </div>

                @if($letter->letter_file)
                    <div class="mb-3">
                        <h6 class="text-muted">File Surat</h6>
                        <a href="{{ asset('storage/' . $letter->letter_file) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                            <i class="fas fa-download"></i> Download Surat
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Status Permintaan</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <small class="text-muted d-block mb-2">Status Saat Ini</small>
                    @switch($letter->status)
                        @case('menunggu')
                            <span class="badge bg-warning" style="font-size: 1rem;">Menunggu</span>
                            @break
                        @case('diproses')
                            <span class="badge bg-info" style="font-size: 1rem;">Diproses</span>
                            @break
                        @case('siap_diambil')
                            <span class="badge bg-success" style="font-size: 1rem;">Siap Diambil</span>
                            @break
                        @case('diambil')
                            <span class="badge bg-primary" style="font-size: 1rem;">Diambil</span>
                            @break
                        @case('ditolak')
                            <span class="badge bg-danger" style="font-size: 1rem;">Ditolak</span>
                            @break
                    @endswitch
                </div>

                <div class="mb-4">
                    <small class="text-muted d-block mb-2">Tanggal Permintaan</small>
                    <p class="mb-0"><strong>{{ $letter->created_at->format('d M Y H:i') }}</strong></p>
                </div>

                @if($letter->ready_at)
                    <div class="mb-4">
                        <small class="text-muted d-block mb-2">Tanggal Siap</small>
                        <p class="mb-0"><strong>{{ $letter->ready_at->format('d M Y H:i') }}</strong></p>
                    </div>
                @endif

                @if($letter->taken_at)
                    <div class="mb-4">
                        <small class="text-muted d-block mb-2">Tanggal Diambil</small>
                        <p class="mb-0"><strong>{{ $letter->taken_at->format('d M Y H:i') }}</strong></p>
                    </div>
                @endif

                <hr>

                <a href="{{ route('admin.letters.edit', $letter->id) }}" class="btn btn-primary w-100">
                    <i class="fas fa-edit"></i> Update Status
                </a>
                <form action="{{ route('admin.letters.destroy', $letter->id) }}" method="POST" class="mt-2" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permintaan surat ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
