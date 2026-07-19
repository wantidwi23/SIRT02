@extends((auth()->check() && auth()->user()->isAdmin()) ? 'layouts.admin' : 'layouts.app')

@section('content')

@if(auth()->check() && auth()->user()->isAdmin())
<!-- Admin View - Full Page -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Detail Permintaan Surat</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted">Warga/Pemohon</h6>
                <p class="fs-5">
                    @if($letter->resident)
                    <a href="{{ route('residents.show', $letter->resident) }}">
                        {{ $letter->resident->name }}
                    </a>
                    @else
                    {{ $letter->applicant_name ?? '-' }}
                    @endif
                </p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">Jenis Surat</h6>
                <p class="fs-5">{{ ucfirst(str_replace('_', ' ', $letter->type)) }}</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted">Status</h6>
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
            <div class="col-md-6">
                <h6 class="text-muted">Tanggal Dibuat</h6>
                <p>{{ $letter->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        <div class="mb-4">
            <h6 class="text-muted">Tujuan Penggunaan</h6>
            <p>{{ $letter->purpose }}</p>
        </div>

        @if($letter->notes)
        <div class="mb-4">
            <h6 class="text-muted">Catatan</h6>
            <p>{{ $letter->notes }}</p>
        </div>
        @endif

        @if($letter->ready_at)
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted">Siap Diambil</h6>
                <p>{{ $letter->ready_at->format('d M Y H:i') }}</p>
            </div>
            @if($letter->taken_at)
            <div class="col-md-6">
                <h6 class="text-muted">Tanggal Diambil</h6>
                <p>{{ $letter->taken_at->format('d M Y H:i') }}</p>
            </div>
            @endif
        </div>
        @endif

        @if($letter->identity_image)
        <div class="mb-4">
            <h6 class="text-muted">Foto KTP/KK</h6>
            <div class="card border-light">
                <div class="card-body">
                    <img src="{{ asset('storage/' . $letter->identity_image) }}" alt="KTP/KK" class="img-fluid rounded" style="max-width: 100%; max-height: 500px; object-fit: contain;">
                </div>
            </div>
        </div>
        @endif

        @if($letter->letter_file)
        <div class="mb-4">
            <h6 class="text-muted">File Surat</h6>
            <p>
                <a href="{{ asset('storage/' . $letter->letter_file) }}" class="btn btn-outline-primary" target="_blank">
                    <i class="bi bi-download"></i> Download PDF
                </a>
            </p>
        </div>
        @endif

        @if($letter->admin_notes)
        <div class="alert alert-info">
            <strong>Catatan Admin:</strong>
            <p class="mb-0">{{ $letter->admin_notes }}</p>
        </div>
        @endif

        <hr class="my-4">

        <h6 class="mb-3">Informasi Warga</h6>
        @if($letter->resident)
        <p>
            <strong>Nama</strong><br>
            {{ $letter->resident->name }}
        </p>
        <p>
            <strong>NIK</strong><br>
            {{ $letter->resident->nik }}
        </p>
        <p>
            <strong>Email</strong><br>
            {{ $letter->resident->email }}
        </p>
        <p>
            <strong>Telepon</strong><br>
            {{ $letter->resident->phone ?? '-' }}
        </p>
        @else
        <p>
            <strong>Nama Pemohon</strong><br>
            {{ $letter->applicant_name ?? '-' }}
        </p>
        <p>
            <strong>NIK</strong><br>
            {{ $letter->applicant_nik ?? '-' }}
        </p>
        <p class="text-muted">
            <small>Pemohon tidak terikat ke data warga</small>
        </p>
        @endif
    </div>
    <div class="card-footer bg-light">
        <a href="{{ route('admin.letters.edit', $letter) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="{{ route('admin.letters.destroy', $letter) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin?')">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </form>
        <a href="{{ route('admin.letters.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@else
<!-- User View - Redirect to Index with Message -->
<script>
    window.location.href = '{{ route("letters.index") }}';
</script>
@endif



@endsection
