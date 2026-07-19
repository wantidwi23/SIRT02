<!-- Modal Buat Permintaan Surat -->
<div class="modal fade" id="createLetterModal" tabindex="-1" aria-labelledby="createLetterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createLetterModalLabel">
                    <i class="bi bi-plus-circle"></i> Buat Permintaan Surat
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('letters.store') }}" method="POST" id="createLetterForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="applicant_name" class="form-label">Nama Pemohon</label>
                        <input type="text" class="form-control @error('applicant_name') is-invalid @enderror" id="applicant_name" name="applicant_name" required placeholder="Masukkan nama lengkap" value="{{ old('applicant_name') }}">
                        @error('applicant_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="applicant_nik" class="form-label">NIK</label>
                        <input type="text" class="form-control @error('applicant_nik') is-invalid @enderror" id="applicant_nik" name="applicant_nik" required placeholder="Masukkan NIK (16 digit)" maxlength="16" inputmode="numeric" value="{{ old('applicant_nik') }}">
                        <small class="text-muted">16 digit angka</small>
                        @error('applicant_nik')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="identity_image" class="form-label">Foto KTP/KK</label>
                        <input type="file" class="form-control @error('identity_image') is-invalid @enderror" id="identity_image" name="identity_image" accept="image/jpeg,image/png,image/jpg,image/gif" required>
                        <small class="text-muted">Format: JPEG, PNG, JPG, GIF (Max 2MB)</small>
                        @error('identity_image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="letter_category_id" class="form-label">Jenis Surat</label>
                        <select class="form-select @error('letter_category_id') is-invalid @enderror" id="letter_category_id" name="letter_category_id" required>
                            <option value="">-- Pilih Jenis Surat --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('letter_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('letter_category_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="purpose" class="form-label">Tujuan Penggunaan</label>
                        <textarea class="form-control @error('purpose') is-invalid @enderror" id="purpose" name="purpose" rows="3" required placeholder="Jelaskan tujuan penggunaan surat ini">{{ old('purpose') }}</textarea>
                        @error('purpose')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan Tambahan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="2" placeholder="Opsional">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info alert-sm mb-0">
                        <i class="bi bi-info-circle"></i>
                        <strong>Informasi:</strong> Surat akan diproses dalam 1-3 hari kerja. Anda akan dihubungi ketika surat sudah siap diambil.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> Buat Permintaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
