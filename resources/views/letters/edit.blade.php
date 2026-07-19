@extends((auth()->check() && auth()->user()->isAdmin()) ? 'layouts.admin' : 'layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Update Status Surat</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('letters.show', $letter) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ ucfirst(str_replace('_', ' ', $letter->type)) }} - {{ $letter->resident->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ (auth()->check() && auth()->user()->isAdmin()) ? route('admin.letters.update', $letter) : route('letters.update', $letter) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="menunggu" {{ old('status', $letter->status) === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diproses" {{ old('status', $letter->status) === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="siap_diambil" {{ old('status', $letter->status) === 'siap_diambil' ? 'selected' : '' }}>Siap Diambil</option>
                                <option value="diambil" {{ old('status', $letter->status) === 'diambil' ? 'selected' : '' }}>Diambil</option>
                                <option value="ditolak" {{ old('status', $letter->status) === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="letter_file" class="form-label">File Surat (PDF)</label>
                            <input type="file" class="form-control @error('letter_file') is-invalid @enderror" id="letter_file" name="letter_file" accept=".pdf">
                            <small class="text-muted">Pilih file surat yang sudah jadi (format PDF, max 5MB)</small>
                            @if($letter->letter_file)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $letter->letter_file) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                        <i class="bi bi-download"></i> Download File Saat Ini
                                    </a>
                                </div>
                            @endif
                            @error('letter_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="admin_notes" class="form-label">Catatan Admin</label>
                            <textarea class="form-control @error('admin_notes') is-invalid @enderror" id="admin_notes" name="admin_notes" rows="4" placeholder="Catatan untuk warga atau internal">{{ old('admin_notes', $letter->admin_notes) }}</textarea>
                            @error('admin_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            <strong>Info:</strong> Saat status diubah menjadi "Siap Diambil", sistem akan otomatis merekam waktu siapnya surat. Saat status diubah menjadi "Diambil", sistem akan merekam waktu pengambilan.
                        </div>

                        <div class="d-grid gap-2 d-sm-flex">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('letters.show', $letter) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
