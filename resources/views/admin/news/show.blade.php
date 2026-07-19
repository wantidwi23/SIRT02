@extends('layouts.admin')

@section('title', $news->title)
@section('page_title', $news->title)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.news.index') }}">Berita</a></li>
    <li class="breadcrumb-item active">{{ $news->title }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ $news->title }}</h3>
                    <div>
                        <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-8">
                        @if($news->image)
                            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="img-fluid rounded mb-3" style="max-width: 100%;">
                        @endif
                        
                        <div class="content">
                            {!! nl2br(e($news->content)) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Informasi Berita</h6>
                                <hr>
                                
                                <div class="mb-3">
                                    <small class="text-muted">Status</small><br>
                                    @if($news->status === 'published')
                                        <span class="badge badge-success">Dipublikasikan</span>
                                    @elseif($news->status === 'draft')
                                        <span class="badge badge-warning">Draft</span>
                                    @else
                                        <span class="badge badge-secondary">Diarsipkan</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted">Penulis</small><br>
                                    <strong>{{ $news->user->name }}</strong>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted">Tanggal Publikasi</small><br>
                                    <strong>
                                        @if($news->published_at)
                                            {{ $news->published_at->format('d F Y H:i') }}
                                        @else
                                            <em class="text-muted">Belum dipublikasikan</em>
                                        @endif
                                    </strong>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted">Dibuat</small><br>
                                    <strong>{{ $news->created_at->format('d F Y H:i') }}</strong>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted">Terakhir Diubah</small><br>
                                    <strong>{{ $news->updated_at->format('d F Y H:i') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
