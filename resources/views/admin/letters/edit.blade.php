@extends('layouts.admin')

@section('title', 'Update Status Surat')
@section('page_title', 'Update Status Surat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.letters.index') }}">Permintaan Surat</a></li>
    <li class="breadcrumb-item active">Update Status</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Form Update Status Surat</h3>
            </div>
            <div class="card-body">
                <div class="mb-4 p-3 bg-light rounded">
                    <h6 class="mb-3">Informasi Permintaan</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">Nama Warga/Pemohon</small><br>
                            <strong>
                                @if($letter->resident)
                                    {{ $letter->resident->name }}
                                @else
                                    {{ $letter->applicant_name ?? '-' }}
                                @endif
                            </strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Jenis Surat</small><br>
                            <strong>{{ $letter->category->name ?? '-' }}</strong>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.letters.update', $letter->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="status" class="form-label">Status Permintaan <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="menunggu" {{ old('status', $letter->status) === 'menunggu' ? 'selected' : '' }}>
                                Menunggu
                            </option>
                            <option value="diproses" {{ old('status', $letter->status) === 'diproses' ? 'selected' : '' }}>
                                Diproses
                            </option>
                            <option value="siap_diambil" {{ old('status', $letter->status) === 'siap_diambil' ? 'selected' : '' }}>
                                Siap Diambil
                            </option>
                            <option value="diambil" {{ old('status', $letter->status) === 'diambil' ? 'selected' : '' }}>
                                Diambil
                            </option>
                            <option value="ditolak" {{ old('status', $letter->status) === 'ditolak' ? 'selected' : '' }}>
                                Ditolak
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="letter_file" class="form-label">File Surat (PDF)</label>
                        <input type="file" class="form-control @error('letter_file') is-invalid @enderror" id="letter_file" name="letter_file" accept=".pdf">
                        <small class="form-text text-muted d-block mt-1">Format: PDF | Max: 5MB</small>
                        @if($letter->letter_file)
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $letter->letter_file) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="fas fa-download"></i> Download File Saat Ini
                                </a>
                            </div>
                        @endif
                        @error('letter_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Catatan Admin</label>
                        <textarea class="form-control @error('admin_notes') is-invalid @enderror" id="admin_notes" name="admin_notes" rows="4" placeholder="Tambahkan catatan untuk warga atau catatan internal...">{{ old('admin_notes', $letter->admin_notes) }}</textarea>
                        @error('admin_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Informasi:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Saat status diubah menjadi <strong>"Siap Diambil"</strong>, sistem akan otomatis merekam waktu siapnya surat</li>
                            <li>Saat status diubah menjadi <strong>"Diambil"</strong>, sistem akan merekam waktu pengambilan</li>
                        </ul>
                    </div>

                    <div class="d-grid gap-2 d-sm-flex">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.letters.show', $letter->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
