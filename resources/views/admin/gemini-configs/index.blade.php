@extends('layouts.admin')

@section('title', 'Konfigurasi Gemini API')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-cog"></i> Konfigurasi Gemini API
                    </h3>
                    <a href="{{ route('admin.gemini-configs.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Konfigurasi
                    </a>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if ($configs->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada konfigurasi Gemini API. 
                            <a href="{{ route('admin.gemini-configs.create') }}">Buat yang baru</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Model</th>
                                        <th>Status</th>
                                        <th>Temperature</th>
                                        <th>Max Tokens</th>
                                        <th>Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($configs as $config)
                                        <tr>
                                            <td>
                                                <strong>{{ $config->name }}</strong>
                                                @if ($config->is_active)
                                                    <span class="badge badge-success ml-2">AKTIF</span>
                                                @endif
                                            </td>
                                            <td>
                                                <code>{{ $config->model }}</code>
                                            </td>
                                            <td>
                                                @if ($config->is_active)
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check-circle"></i> Aktif
                                                    </span>
                                                @else
                                                    <span class="badge badge-secondary">
                                                        <i class="fas fa-times-circle"></i> Tidak Aktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $config->temperature }}</td>
                                            <td>{{ $config->max_output_tokens }}</td>
                                            <td>
                                                <small class="text-muted">{{ $config->created_at->format('d M Y') }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('admin.gemini-configs.show', $config) }}" 
                                                       class="btn btn-info" title="Lihat">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.gemini-configs.edit', $config) }}" 
                                                       class="btn btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if (!$config->is_active)
                                                        <form action="{{ route('admin.gemini-configs.set-active', $config) }}" 
                                                              method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success" title="Aktifkan">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.gemini-configs.destroy', $config) }}" 
                                                              method="POST" style="display: inline;" 
                                                              onsubmit="return confirm('Yakin ingin menghapus?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $configs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
