@extends('layouts.app')

@section('content')

{{-- ===================================================== --}}
{{-- HEADER HALAMAN --}}
{{-- ===================================================== --}}
<div class="mb-4">

    {{-- Judul halaman --}}
    <h2 class="mb-1">
        Categories Chart Of Accounts
    </h2>

    {{-- Deskripsi halaman --}}
    <p class="text-muted small mb-0">
        Manage your financial account categories.
    </p>
</div>

{{-- ===================================================== --}}
{{-- CARD FILTER & SEARCH --}}
{{-- ===================================================== --}}
<div class="card border-0 shadow-sm p-3 mb-4"
    style="border-radius:20px;">

    {{-- Form GET untuk filter data --}}
    <form method="GET" action="/categories">

        <div class="row g-3 align-items-end">

            {{-- ========================================= --}}
            {{-- SEARCH KATEGORI --}}
            {{-- ========================================= --}}
            <div class="col-md-4">

                {{-- Label input --}}
                <label
                    class="form-label small text-muted fw-semibold text-uppercase"
                    style="font-size:11px;letter-spacing:.05em;">

                    Cari Kategori
                </label>

                {{-- Wrapper input + icon --}}
                <div class="position-relative">

                    {{-- Icon search --}}
                    <span
                        class="position-absolute"
                        style="
                            left:12px;
                            top:50%;
                            transform:translateY(-50%);
                            color:#9ca3af;
                        ">

                        <i class="bi bi-search"></i>
                    </span>

                    {{-- Input search --}}
                    <input
                        type="text"
                        name="search"
                        class="form-control ps-5"
                        placeholder="Cari nama kategori..."
                        value="{{ request('search') }}">
                </div>
            </div>

            {{-- ========================================= --}}
            {{-- FILTER TANGGAL MULAI --}}
            {{-- ========================================= --}}
            <div class="col-md-3">

                <label
                    class="form-label small text-muted fw-semibold text-uppercase"
                    style="font-size:11px;letter-spacing:.05em;">

                    Mulai Tanggal
                </label>

                {{-- Input tanggal awal --}}
                <input
                    type="date"
                    name="start_date"
                    class="form-control"
                    value="{{ request('start_date') }}">
            </div>

            {{-- ========================================= --}}
            {{-- FILTER TANGGAL AKHIR --}}
            {{-- ========================================= --}}
            <div class="col-md-3">

                <label
                    class="form-label small text-muted fw-semibold text-uppercase"
                    style="font-size:11px;letter-spacing:.05em;">

                    Sampai Tanggal
                </label>

                {{-- Input tanggal akhir --}}
                <input
                    type="date"
                    name="end_date"
                    class="form-control"
                    value="{{ request('end_date') }}">
            </div>

            {{-- ========================================= --}}
            {{-- BUTTON FILTER --}}
            {{-- ========================================= --}}
            <div class="col-md-2 d-grid">

                {{-- Submit filter --}}
                <button class="btn btn-primary">
                    Terapkan
                </button>
            </div>
        </div>

        {{-- ========================================= --}}
        {{-- BUTTON RESET FILTER --}}
        {{-- Muncul jika ada filter aktif --}}
        {{-- ========================================= --}}
        @if(request()->hasAny([
            'search',
            'start_date',
            'end_date'
        ]))

        <div class="text-end mt-3">

            <a href="/categories"
                class="text-danger small text-decoration-none">

                <i class="bi bi-x-circle"></i>

                Reset Filter
            </a>
        </div>
        @endif
    </form>
</div>

{{-- ===================================================== --}}
{{-- CEK APAKAH DATA CATEGORY KOSONG --}}
{{-- ===================================================== --}}
@if($categories->isEmpty())

{{-- Tampilan jika data kosong --}}
<div class="text-center text-muted py-5">

    <i class="bi bi-inbox fs-3 d-block mb-2"></i>

    Belum ada kategori.
    Tambahkan kategori pertama kamu.
</div>

@else

{{-- ===================================================== --}}
{{-- LIST CATEGORY --}}
{{-- ===================================================== --}}
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 mb-3">

    {{-- Looping semua category --}}
    @foreach($categories as $item)

    <div class="col">

        {{-- Card category --}}
        <div class="card border-0 shadow-sm text-center p-3 h-100"
            style="border-radius:24px;">

            <div class="card-body d-flex flex-column justify-content-between">

                {{-- Informasi category --}}
                <div>

                    {{-- Nama category --}}
                    <h5 class="fw-bold mb-1">
                        {{ $item->name }}
                    </h5>

                    {{-- Tanggal dibuat --}}
                    <p class="text-muted small mb-4">

                        {{ $item->created_at->format('d M Y') }}
                    </p>
                </div>

                {{-- Button action --}}
                <div class="d-flex gap-2">

                    {{-- ================================= --}}
                    {{-- BUTTON EDIT --}}
                    {{-- ================================= --}}
                    <button
                        class="btn w-50"
                        style="
                            background:#fef3c7;
                            color:#92400e;
                            border:none;
                            border-radius:999px;
                            font-size:13px;
                            font-weight:500;
                        "
                        data-bs-toggle="modal"
                        data-bs-target="#editCategoryModal{{ $item->id }}">

                        Edit
                    </button>

                    {{-- ================================= --}}
                    {{-- BUTTON DELETE --}}
                    {{-- ================================= --}}
                    <button
                        class="btn w-50"
                        style="
                            background:#2563eb;
                            color:white;
                            border:none;
                            border-radius:999px;
                            font-size:13px;
                            font-weight:500;
                        "
                        data-bs-toggle="modal"
                        data-bs-target="#deleteCategoryModal{{ $item->id }}">

                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- MODAL EDIT CATEGORY --}}
    {{-- ================================================= --}}
    <div class="modal fade"
        id="editCategoryModal{{ $item->id }}"
        tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                {{-- Form update category --}}
                <form
                    action="/categories/{{ $item->id }}"
                    method="POST">

                    @csrf

                    {{-- Method PUT --}}
                    @method('PUT')

                    {{-- Header modal --}}
                    <div class="modal-header">

                        <h5 class="modal-title">
                            Edit Kategori
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                        </button>
                    </div>

                    {{-- Body modal --}}
                    <div class="modal-body">

                        <label class="form-label">
                            Nama Kategori
                        </label>

                        {{-- Input nama category --}}
                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            value="{{ $item->name }}"
                            required>
                    </div>

                    {{-- Footer modal --}}
                    <div class="modal-footer">

                        {{-- Button batal --}}
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                            Batal
                        </button>

                        {{-- Button submit --}}
                        <button class="btn btn-warning">

                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- MODAL DELETE CATEGORY --}}
    {{-- ================================================= --}}
    <div class="modal fade"
        id="deleteCategoryModal{{ $item->id }}"
        tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                {{-- Form delete --}}
                <form
                    action="/categories/{{ $item->id }}"
                    method="POST">

                    @csrf

                    {{-- Method DELETE --}}
                    @method('DELETE')

                    {{-- Header modal --}}
                    <div class="modal-header">

                        <h5 class="modal-title text-danger">
                            Hapus Kategori
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                        </button>
                    </div>

                    {{-- Body modal --}}
                    <div class="modal-body">

                        <p>
                            Hapus kategori
                            <strong>
                                {{ $item->name }}
                            </strong>?
                        </p>
                    </div>

                    {{-- Footer modal --}}
                    <div class="modal-footer">

                        {{-- Button batal --}}
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                            Batal
                        </button>

                        {{-- Button delete --}}
                        <button class="btn btn-danger">

                            Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endforeach
</div>
@endif

{{-- ===================================================== --}}
{{-- BOTTOM ACTION BAR --}}
{{-- ===================================================== --}}
<div
    class="position-fixed bottom-0 start-0 end-0 bg-white border-top
    d-flex align-items-center justify-content-between
    px-3 py-2 shadow-sm"
    style="z-index:1000;">

    {{-- Jumlah kategori --}}
    <span class="text-muted small">

        Menampilkan
        <strong class="text-dark">

            {{ $categories->count() }} kategori
        </strong>
    </span>

    {{-- Button tambah kategori --}}
    <button
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#addCategoryModal">

        + Tambah Kategori
    </button>
</div>

{{-- ===================================================== --}}
{{-- MODAL TAMBAH CATEGORY --}}
{{-- ===================================================== --}}
<div class="modal fade"
    id="addCategoryModal"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            {{-- Form tambah category --}}
            <form action="/categories" method="POST">

                @csrf

                {{-- Header modal --}}
                <div class="modal-header">

                    <h5 class="modal-title">
                        Tambah Kategori
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                {{-- Body modal --}}
                <div class="modal-body">

                    <label class="form-label">
                        Nama Kategori
                    </label>

                    {{-- Input category --}}
                    <input
                        type="text"
                        class="form-control"
                        name="name"
                        placeholder="
                            Contoh:
                            Expense,
                            Income,
                            Asset...
                        "
                        required>
                </div>

                {{-- Footer modal --}}
                <div class="modal-footer">

                    {{-- Button batal --}}
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Batal
                    </button>

                    {{-- Button submit --}}
                    <button class="btn btn-primary">

                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection