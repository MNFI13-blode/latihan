@extends('layouts.app')

@section('content')

{{-- ===================================================== --}}
{{-- HEADER HALAMAN --}}
{{-- ===================================================== --}}
<div class="mb-4">

    {{-- Judul halaman --}}
    <h2 class="mb-1">
        Master Chart Of Accounts
    </h2>

    {{-- Deskripsi halaman --}}
    <p class="text-muted small mb-0">
        Manage Chart of Accounts data.
    </p>
</div>
{{-- ===================================================== --}}
{{-- VALIDATION ERROR ALERT --}}
{{-- ===================================================== --}}

{{-- 
    Mengecek apakah ada error validasi.
    
    Contoh:
    - input kosong
    - format salah
    - data tidak valid
--}}
@if ($errors->any())

{{-- ===================================================== --}}
{{-- ALERT BOX --}}
{{-- ===================================================== --}}
<div
    class="
        alert
        alert-danger
        alert-dismissible
        fade
        show
    "
    role="alert"
>

    {{-- Judul alert --}}
    <strong>

        Terjadi kesalahan!
    </strong>

    {{-- ================================================= --}}
    {{-- LIST ERROR --}}
    {{-- ================================================= --}}
    
    <ul class="mb-0 mt-2">

        {{-- 
            Loop semua pesan error
            dari validation Laravel
        --}}
        @foreach ($errors->all() as $error)

        <li>

            {{-- Tampilkan pesan error --}}
            {{ $error }}
        </li>

        @endforeach
    </ul>

    {{-- ================================================= --}}
    {{-- BUTTON CLOSE ALERT --}}
    {{-- ================================================= --}}
    
    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert"
    ></button>

</div>
@endif

{{-- ===================================================== --}}
{{-- CARD FILTER & SEARCH --}}
{{-- ===================================================== --}}
<div class="card border-0 shadow-sm p-3 mb-4"
    style="border-radius:20px;">

    {{-- Form GET filter --}}
    <form method="GET" action="/coas">

        <div class="row g-3 align-items-end">

            {{-- ========================================= --}}
            {{-- SEARCH COA --}}
            {{-- ========================================= --}}
            <div class="col-md-5">

                {{-- Label --}}
                <label
                    class="form-label small text-muted fw-semibold text-uppercase"
                    style="font-size:11px;letter-spacing:.05em;">

                    Cari COA
                </label>

                {{-- Wrapper icon + input --}}
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
                        placeholder="Cari kode atau nama akun..."
                        value="{{ request('search') }}">
                </div>
            </div>

            {{-- ========================================= --}}
            {{-- FILTER CATEGORY --}}
            {{-- ========================================= --}}
            <div class="col-md-4">

                {{-- Label --}}
                <label
                    class="form-label small text-muted fw-semibold text-uppercase"
                    style="font-size:11px;letter-spacing:.05em;">

                    Kategori
                </label>

                {{-- Dropdown category --}}
                <select
                    name="category_id"
                    class="form-select">

                    {{-- Default option --}}
                    <option value="">
                        Semua Kategori
                    </option>

                    {{-- Loop category --}}
                    @foreach($categories as $category)

                    <option
                        value="{{ $category->id }}"
                        {{
                            request('category_id')
                            == $category->id
                            ? 'selected'
                            : ''
                        }}>

                        {{ $category->name }}
                    </option>

                    @endforeach
                </select>
            </div>

            {{-- ========================================= --}}
            {{-- BUTTON FILTER --}}
            {{-- ========================================= --}}
            <div class="col-md-3 d-grid">

                {{-- Submit filter --}}
                <button class="btn btn-primary">

                    Terapkan
                </button>
            </div>
        </div>

        {{-- ========================================= --}}
        {{-- RESET FILTER --}}
        {{-- Tampil jika ada filter aktif --}}
        {{-- ========================================= --}}
        @if(request()->hasAny([
            'search',
            'category_id'
        ]))

        <div class="text-end mt-3">

            <a href="/coas"
                class="text-danger small text-decoration-none">

                <i class="bi bi-x-circle"></i>

                Reset Filter
            </a>
        </div>

        @endif
    </form>
</div>

{{-- ===================================================== --}}
{{-- CEK APAKAH DATA COA KOSONG --}}
{{-- ===================================================== --}}
@if($coas->isEmpty())

{{-- Tampilan jika data kosong --}}
<div class="text-center text-muted py-5">

    <i class="bi bi-inbox fs-3 d-block mb-2"></i>

    Belum ada data COA.
</div>

@else

{{-- ===================================================== --}}
{{-- LIST DATA COA --}}
{{-- ===================================================== --}}
<div
    class="row row-cols-1 row-cols-sm-2
    row-cols-md-3 row-cols-lg-4
    g-3 mb-5">

    {{-- Loop semua COA --}}
    @foreach($coas as $item)

    <div class="col">

        {{-- Card COA --}}
        <div
            class="card border-0 shadow-sm h-100"
            style="
                border-radius:24px;
                background:white;
                min-height:18vh;
            ">

            <div
                class="card-body d-flex flex-column justify-content-between">

                <div>

                    {{-- ================================= --}}
                    {{-- BADGE KODE COA --}}
                    {{-- ================================= --}}
                    <div class="text-center mb-2">

                        <span
                            class="badge rounded-pill
                            text-bg-primary px-3 py-2">

                            {{ $item->code }}
                        </span>
                    </div>

                    {{-- Nama COA --}}
                    <h5 class="fw-bold text-center mb-1">

                        {{ $item->name }}
                    </h5>

                    {{-- Nama category --}}
                    <p class="text-muted text-center small mb-4">

                        {{ $item->category->name ?? '-' }}
                    </p>

                    {{-- Tanggal dibuat --}}
                    <p
                        class="text-muted text-center"
                        style="font-size:12px;">

                        {{ $item->created_at->format('d M Y') }}
                    </p>
                </div>

                {{-- ================================= --}}
                {{-- BUTTON ACTION --}}
                {{-- ================================= --}}
                <div class="d-flex gap-2">

                    {{-- BUTTON EDIT --}}
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
                        data-bs-target="#editCoaModal{{ $item->id }}">

                        Edit
                    </button>

                    {{-- BUTTON DELETE --}}
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
                        data-bs-target="#deleteCoaModal{{ $item->id }}">

                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- MODAL EDIT COA --}}
    {{-- ================================================= --}}
    <div
        class="modal fade"
        id="editCoaModal{{ $item->id }}"
        tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                {{-- Form update COA --}}
                <form
                    action="/coas/{{ $item->id }}"
                    method="POST">

                    @csrf

                    {{-- Method PUT --}}
                    @method('PUT')

                    {{-- Header modal --}}
                    <div class="modal-header">

                        <h5 class="modal-title">

                            Edit COA
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                        </button>
                    </div>

                    {{-- Body modal --}}
                    <div class="modal-body">

                        {{-- Input kode --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Kode
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="code"
                                value="{{ $item->code }}"
                                required>
                        </div>

                        {{-- Input nama --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Nama
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="name"
                                value="{{ $item->name }}"
                                required>
                        </div>

                        {{-- Dropdown category --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Kategori
                            </label>

                            <select
                                class="form-select"
                                name="category_id"
                                required>

                                {{-- Loop category --}}
                                @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{
                                        $item->category_id
                                        == $category->id
                                        ? 'selected'
                                        : ''
                                    }}>

                                    {{ $category->name }}
                                </option>

                                @endforeach
                            </select>
                        </div>
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

                        {{-- Button update --}}
                        <button class="btn btn-warning">

                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- MODAL DELETE COA --}}
    {{-- ================================================= --}}
    <div
        class="modal fade"
        id="deleteCoaModal{{ $item->id }}"
        tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                {{-- Form delete --}}
                <form
                    action="/coas/{{ $item->id }}"
                    method="POST">

                    @csrf

                    {{-- Method DELETE --}}
                    @method('DELETE')

                    {{-- Header modal --}}
                    <div class="modal-header">

                        <h5 class="modal-title text-danger">

                            Hapus COA
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
                            Hapus COA
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
    class="position-fixed bottom-0 start-0 end-0
    bg-white border-top
    d-flex align-items-center justify-content-between
    px-3 py-2 shadow-sm"
    style="z-index:1000;">

    {{-- Total data --}}
    <span class="text-muted small">

        Menampilkan
        <strong class="text-dark">

            {{ $coas->count() }} akun
        </strong>
    </span>

    {{-- Button tambah COA --}}
    <button
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#addCoaModal">

        + Tambah COA
    </button>
</div>

{{-- ===================================================== --}}
{{-- MODAL TAMBAH COA --}}
{{-- ===================================================== --}}
<div
    class="modal fade"
    id="addCoaModal"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            {{-- Form tambah COA --}}
            <form action="/coas" method="POST">

                @csrf

                {{-- Header modal --}}
                <div class="modal-header">

                    <h5 class="modal-title">

                        Tambah COA
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                {{-- Body modal --}}
                <div class="modal-body">

                    {{-- Input kode --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Kode
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="code"
                            placeholder="Contoh: 501"
                            required>
                    </div>

                    {{-- Input nama --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Nama
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            placeholder="
                                Contoh:
                                Belanja Bulanan
                            "
                            required>
                    </div>

                    {{-- Dropdown category --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Kategori
                        </label>

                        <select
                            class="form-select"
                            name="category_id"
                            required>

                            {{-- Default option --}}
                            <option
                                value=""
                                disabled
                                selected>

                                Pilih Kategori
                            </option>

                            {{-- Loop category --}}
                            @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}">

                                {{ $category->name }}
                            </option>

                            @endforeach
                        </select>
                    </div>
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