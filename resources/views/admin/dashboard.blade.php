@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <!-- Small boxes (Stat box) -->
    @include('partials.admin.stat-boxes')

    <!-- Main row -->
    <div class="row">
        <!-- Latest Reports -->
        @include('partials.admin.latest-reports')

        <!-- Latest Letters -->
        @include('partials.admin.latest-letters')
    </div>
    <!-- /.row -->
@endsection
