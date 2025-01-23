@extends('admin.admin')

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Ranking</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Berita</a>
                </li>
            </ul>
        </div>
        <a href="#" class="btn-download" data-bs-toggle="modal" data-bs-target="#addNewsModal">
            <i class='bx bxs-plus-circle'></i>
            <span class="text">Tambah Berita</span>
        </a>
    </div>

    <!-- News List -->
@endsection