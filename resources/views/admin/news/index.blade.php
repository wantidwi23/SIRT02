@extends('layouts.admin')

@section('title', 'Kelola Berita')
@section('page_title', 'Kelola Berita')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Berita</li>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Berita
        </a>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Berita</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Status</th>
                    <th>Tanggal Publikasi</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($news as $item)
                <tr>
                    <td>
                        <strong>{{ $item->title }}</strong><br>
                        <small class="text-muted">{{ Str::limit($item->content, 50) }}</small>
                    </td>
                    <td>{{ $item->user->name }}</td>
                    <td>
                        @if($item->status === 'published')
                            <span class="badge badge-success">Dipublikasikan</span>
                        @elseif($item->status === 'draft')
                            <span class="badge badge-warning">Draft</span>
                        @else
                            <span class="badge badge-secondary">Diarsipkan</span>
                        @endif
                    </td>
                    <td>
                        @if($item->published_at)
                            {{ $item->published_at->format('d-m-Y H:i') }}
                        @else
                            <em class="text-muted">-</em>
                        @endif
                    </td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('admin.news.show', $item->id) }}" class="btn btn-sm btn-info" title="Lihat">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        <i class="fas fa-inbox"></i> Tidak ada berita
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if ($news->total() > 0)
<div class="row mt-4">
    <div class="col-12">
        <nav aria-label="Page navigation">
            {{ $news->links() }}
        </nav>
    </div>
</div>
@endif

@endsection
