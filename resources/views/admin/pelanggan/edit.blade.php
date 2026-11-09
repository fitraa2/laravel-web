@extends('layouts.admin.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://w3.org"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Pelanggan</li>
                </ol>
            </nav>
            <h2 class="h4">Edit Pelanggan</h2>
            <p class="mb-0">Form untuk memperbarui data Pelanggan.</p>
        </div>
        <div>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-gray-800 d-inline-flex align-items-center">Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    <form action="{{ route('pelanggan.update', $pelanggan->pelanggan_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Baris 1: Kolom 1, 2, 3 -->
                        <div class="row mb-3">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">Nama Depan</label>
                                    <input type="text" id="first_name" class="form-control" name="first_name" value="{{ $pelanggan->first_name }}" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="birthday" class="form-label">Hari Ulang Tahun</label>
                                    <input type="date" id="birthday" class="form-control" name="birthday" value="{{ $pelanggan->birthday }}" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" class="form-control" name="email" value="{{ $pelanggan->email }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Baris 2: Kolom 4, 5, 6 -->
                        <div class="row mb-4">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Nama Belakang</label>
                                    <input type="text" id="last_name" class="form-control" name="last_name" value="{{ $pelanggan->last_name }}" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                    <select id="gender" class="form-select" name="gender" required>
                                        <option value="Male" {{ $pelanggan->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ $pelanggan->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Telepon</label>
                                    <input type="text" id="phone" class="form-control" name="phone" value="{{ $pelanggan->phone }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-gray-800 text-white me-2">Simpan</button>
                                <a href="{{ route('pelanggan.index') }}" class="btn btn-outline-warning">Batal</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
