@extends('layouts.app')

@section('content')

{{-- ===================================================== --}}
{{-- HEADER HALAMAN --}}
{{-- ===================================================== --}}
<div class="mb-4">

    {{-- Judul halaman --}}
    <h2 class="mb-1">
        Transaksi Keuangan
    </h2>

    {{-- Deskripsi halaman --}}
    <p class="text-muted small mb-0">
        Record and manage daily debit & credit history.
    </p>
</div>

{{-- ===================================================== --}}
{{-- CARD FILTER --}}
{{-- ===================================================== --}}
<div class="card card-custom p-3 mb-3">

    {{-- Form filter --}}
    <form
        method="GET"
        action="/transactions"
        id="filterForm">

        {{-- ============================================= --}}
        {{-- SEARCH --}}
        {{-- ============================================= --}}
        <div class="mb-3 position-relative">

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
                placeholder="
                    Cari catatan deskripsi,
                    nama COA,
                    atau kode COA...
                "
                value="{{ request('search') }}">
        </div>

        {{-- ============================================= --}}
        {{-- FILTER SECTION --}}
        {{-- ============================================= --}}
        <div class="row g-2 align-items-end">

            {{-- ========================================= --}}
            {{-- FILTER DATE FROM --}}
            {{-- ========================================= --}}
            <div class="col-md">

                <label
                    class="form-label small text-muted
                    fw-semibold text-uppercase"
                    style="
                        font-size:11px;
                        letter-spacing:.05em;
                    ">

                    Mulai Tgl
                </label>

                <input
                    type="date"
                    name="date_from"
                    class="form-control form-control-sm"
                    value="{{ request('date_from') }}">
            </div>

            {{-- ========================================= --}}
            {{-- FILTER DATE TO --}}
            {{-- ========================================= --}}
            <div class="col-md">

                <label
                    class="form-label small text-muted
                    fw-semibold text-uppercase"
                    style="
                        font-size:11px;
                        letter-spacing:.05em;
                    ">

                    Sampai Tgl
                </label>

                <input
                    type="date"
                    name="date_to"
                    class="form-control form-control-sm"
                    value="{{ request('date_to') }}">
            </div>

            {{-- ========================================= --}}
            {{-- FILTER CATEGORY --}}
            {{-- ========================================= --}}
            <div class="col-md">

                <label
                    class="form-label small text-muted
                    fw-semibold text-uppercase"
                    style="
                        font-size:11px;
                        letter-spacing:.05em;
                    ">

                    Kategori
                </label>

                {{-- Dropdown category --}}
                <select
                    name="category_id"
                    class="form-select form-select-sm">

                    {{-- Default --}}
                    <option value="">
                        Semua Kategori
                    </option>

                    {{-- Loop category --}}
                    @foreach($categories as $cat)

                    <option
                        value="{{ $cat->id }}"
                        @selected(
                            request()->get('category_id')
                            == $cat->id
                        )>

                        {{ $cat->name }}
                    </option>

                    @endforeach
                </select>
            </div>

            {{-- ========================================= --}}
            {{-- FILTER COA --}}
            {{-- ========================================= --}}
            <div class="col-md">

                <label
                    class="form-label small text-muted
                    fw-semibold text-uppercase"
                    style="
                        font-size:11px;
                        letter-spacing:.05em;
                    ">

                    COA
                </label>

                {{-- Dropdown COA --}}
                <select
                    name="coa_id"
                    class="form-select form-select-sm">

                    {{-- Default --}}
                    <option value="">
                        Semua Akun
                    </option>

                    {{-- Loop COA --}}
                    @foreach($coas as $coa)

                    <option
                        value="{{ $coa->id }}"
                        @selected(
                            request()->get('coa_id')
                            == $coa->id
                        )>

                        {{ $coa->code }}
                        –
                        {{ $coa->name }}
                    </option>

                    @endforeach
                </select>
            </div>

            {{-- ========================================= --}}
            {{-- SORTING --}}
            {{-- ========================================= --}}
            <div class="col-md">

                <label
                    class="form-label small text-muted
                    fw-semibold text-uppercase"
                    style="
                        font-size:11px;
                        letter-spacing:.05em;
                    ">

                    Urutkan
                </label>

                {{-- Dropdown sorting --}}
                <select
                    name="sort"
                    class="form-select form-select-sm">

                    {{-- Latest --}}
                    <option
                        value="latest"
                        @selected(
                            request()->get(
                                'sort',
                                'latest'
                            ) == 'latest'
                        )>

                        Tgl. Terbaru
                    </option>

                    {{-- Oldest --}}
                    <option
                        value="oldest"
                        @selected(
                            request()->get('sort')
                            == 'oldest'
                        )>

                        Tgl. Terlama
                    </option>

                    {{-- Debit terbesar --}}
                    <option
                        value="debit_desc"
                        @selected(
                            request()->get('sort')
                            == 'debit_desc'
                        )>

                        Debit Terbesar
                    </option>

                    {{-- Credit terbesar --}}
                    <option
                        value="credit_desc"
                        @selected(
                            request()->get('sort')
                            == 'credit_desc'
                        )>

                        Credit Terbesar
                    </option>
                </select>
            </div>

            {{-- ========================================= --}}
            {{-- BUTTON FILTER --}}
            {{-- ========================================= --}}
            <div class="col-md-auto">

                <button
                    type="submit"
                    class="btn btn-primary btn-sm">

                    Terapkan
                </button>
            </div>
        </div>

        {{-- ============================================= --}}
        {{-- RESET FILTER --}}
        {{-- ============================================= --}}
        @if(request()->hasAny([
            'search',
            'date_from',
            'date_to',
            'category_id',
            'coa_id',
            'sort'
        ]))

        <div class="text-end mt-2">

            <a
                href="/transactions"
                class="text-danger small text-decoration-none">

                <i class="bi bi-x-circle"></i>

                Reset Pencarian
            </a>
        </div>

        @endif
    </form>
</div>

{{-- ===================================================== --}}
{{-- TABLE TRANSAKSI --}}
{{-- ===================================================== --}}
<div class="card card-custom p-0 overflow-hidden">

    <table
        class="table table-hover align-middle mb-0">

        {{-- ============================================= --}}
        {{-- TABLE HEADER --}}
        {{-- ============================================= --}}
        <thead class="table-light">

            <tr>

                {{-- Tanggal --}}
                <th
                    class="
                        text-uppercase
                        text-muted
                        small
                        fw-semibold
                        px-3
                        py-2
                    "
                    style="
                        font-size:11px;
                        letter-spacing:.05em;
                    ">

                    Tanggal
                </th>

                {{-- COA / Kategori --}}
                <th
                    class="
                        text-uppercase
                        text-muted
                        small
                        fw-semibold
                        py-2
                    "
                    style="
                        font-size:11px;
                        letter-spacing:.05em;
                    ">

                    COA / Kategori
                </th>

                {{-- Debit --}}
                <th
                    class="
                        text-uppercase
                        text-muted
                        small
                        fw-semibold
                        py-2
                        text-end
                    "
                    style="
                        font-size:11px;
                        letter-spacing:.05em;
                    ">

                    Debit
                </th>

                {{-- Credit --}}
                <th
                    class="
                        text-uppercase
                        text-muted
                        small
                        fw-semibold
                        py-2
                        text-end
                    "
                    style="
                        font-size:11px;
                        letter-spacing:.05em;
                    ">

                    Credit
                </th>

                {{-- Aksi --}}
                <th
                    class="
                        text-uppercase
                        text-muted
                        small
                        fw-semibold
                        py-2
                        text-end
                        pe-3
                    "
                    style="
                        font-size:11px;
                        letter-spacing:.05em;
                    ">

                    Aksi
                </th>
            </tr>
        </thead>

        {{-- ============================================= --}}
        {{-- TABLE BODY --}}
        {{-- ============================================= --}}
        <tbody>

            {{-- Loop transaksi --}}
            @forelse($transactions as $item)

            <tr>

                {{-- ===================================== --}}
                {{-- TANGGAL --}}
                {{-- ===================================== --}}
                <td
                    class="px-3 text-muted small"
                    style="white-space:nowrap;">

                    {{
                        \Carbon\Carbon::parse(
                            $item->date
                        )->format('d M Y')
                    }}
                </td>

                {{-- ===================================== --}}
                {{-- COA & DESKRIPSI --}}
                {{-- ===================================== --}}
                <td>

                    {{-- Nama COA --}}
                    <div
                        class="
                            fw-medium
                            d-flex
                            align-items-center
                            gap-1
                            flex-wrap
                        ">

                        {{ $item->coa->name ?? '-' }}

                        {{-- Badge valas --}}
                        @if($item->is_foreign ?? false)

                        <span
                            class="badge rounded-pill"
                            style="
                                background:#d1fae5;
                                color:#065f46;
                                font-size:11px;
                            ">

                            Valas
                        </span>

                        @endif

                        {{-- Badge restored --}}
                        @if($item->is_restored ?? false)

                        <span
                            class="badge rounded-pill"
                            style="
                                background:#dbeafe;
                                color:#1e40af;
                                font-size:11px;
                            ">

                            Restored
                        </span>

                        @endif
                    </div>

                    {{-- Nama category --}}
                    <div class="small text-muted">

                        {{ $item->coa->category->name ?? '' }}
                    </div>

                    {{-- Deskripsi --}}
                    <div class="small text-muted">

                        {{ $item->description }}
                    </div>
                </td>

                {{-- ===================================== --}}
                {{-- DEBIT --}}
                {{-- ===================================== --}}
                <td class="text-end">

                    @if($item->debit > 0)

                    {{-- Nominal debit --}}
                    <span
                        class="fw-medium text-danger">

                        Rp
                        {{
                            number_format(
                                $item->debit,
                                0,
                                ',',
                                '.'
                            )
                        }}
                    </span>

                    {{-- Foreign amount --}}
                    @if(
                        isset($item->foreign_amount)
                        &&
                        $item->debit > 0
                    )

                    <div class="small text-muted">

                        {{ $item->foreign_amount }}
                    </div>

                    @endif

                    @else

                    {{-- Jika debit kosong --}}
                    <span class="text-muted">

                        –
                    </span>

                    @endif
                </td>

                {{-- ===================================== --}}
                {{-- CREDIT --}}
                {{-- ===================================== --}}
                <td class="text-end">

                    @if($item->credit > 0)

                    {{-- Nominal credit --}}
                    <span
                        class="fw-medium text-success">

                        Rp
                        {{
                            number_format(
                                $item->credit,
                                0,
                                ',',
                                '.'
                            )
                        }}
                    </span>

                    {{-- Foreign amount --}}
                    @if(
                        isset($item->foreign_amount)
                        &&
                        $item->credit > 0
                    )

                    <div class="small text-muted">

                        {{ $item->foreign_amount }}
                    </div>

                    @endif

                    @else

                    {{-- Jika credit kosong --}}
                    <span class="text-muted">

                        –
                    </span>

                    @endif
                </td>

                {{-- ===================================== --}}
                {{-- ACTION BUTTON --}}
                {{-- ===================================== --}}
                <td class="text-end pe-3">

                    {{-- Button edit --}}
                    <button
                        class="btn btn-sm"
                        style="
                            background:#fef3c7;
                            color:#92400e;
                            border:0.5px solid #fde68a;
                        "
                        data-bs-toggle="modal"
                        data-bs-target="
                            #editTransactionModal
                            {{ $item->id }}
                        ">

                        Edit
                    </button>

                    {{-- Button delete --}}
                    <button
                        class="btn btn-sm ms-1"
                        style="
                            background:#fee2e2;
                            color:#991b1b;
                            border:0.5px solid #fecaca;
                        "
                        data-bs-toggle="modal"
                        data-bs-target="
                            #deleteTransactionModal
                            {{ $item->id }}
                        ">

                        Hapus
                    </button>
                </td>
            </tr>

            {{-- ================================================= --}}
            {{-- MODAL EDIT TRANSACTION --}}
            {{-- ================================================= --}}
            {{-- Penjelasan:
                 Modal muncul saat user klik tombol edit
                 untuk mengubah data transaksi --}}
            
            {{-- ================================================= --}}
            {{-- MODAL DELETE TRANSACTION --}}
            {{-- ================================================= --}}
            {{-- Penjelasan:
                 Modal konfirmasi sebelum transaksi dihapus --}}
            
            @empty

            {{-- ========================================= --}}
            {{-- DATA KOSONG --}}
            {{-- ========================================= --}}
            <tr>

                <td
                    colspan="5"
                    class="text-center text-muted py-5">

                    <i
                        class="
                            bi bi-inbox
                            fs-3
                            d-block
                            mb-2
                        ">
                    </i>

                    Tidak ada transaksi ditemukan
                </td>
            </tr>

            @endforelse
        </tbody>
    </table>
</div>

{{-- ===================================================== --}}
{{-- BOTTOM ACTION BAR --}}
{{-- ===================================================== --}}
<div
    class="
        position-fixed
        bottom-0
        start-0
        end-0
        bg-white
        border-top
        d-flex
        align-items-center
        justify-content-between
        px-3
        py-2
        shadow-sm
    "
    style="z-index:1000;">

    {{-- Total transaksi --}}
    <span class="text-muted small">

        Menampilkan

        <strong class="text-dark">

            {{ $transactions->count() }}
            transaksi
        </strong>
    </span>

    {{-- Button tambah transaksi --}}
    <button
        class="btn btn-success"
        data-bs-toggle="modal"
        data-bs-target="#addTransactionModal">

        + Catat Transaksi
    </button>
</div>

{{-- ===================================================== --}}
{{-- MODAL ADD TRANSACTION --}}
{{-- ===================================================== --}}
<div
    class="modal fade"
    id="addTransactionModal"
    tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            {{-- Form tambah transaksi --}}
            <form
                action="/transactions"
                method="POST">

                @csrf

                {{-- Header modal --}}
                <div class="modal-header">

                    <h5 class="modal-title">

                        Catat Transaksi
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                {{-- Body modal --}}
                <div class="modal-body">

                    <div class="row g-3">

                        {{-- Tanggal --}}
                        <div class="col-md-6">

                            <label class="form-label">

                                Tanggal
                            </label>

                            <input
                                type="date"
                                class="form-control"
                                name="date"
                                required>
                        </div>

                        {{-- COA --}}
                        <div class="col-md-6">

                            <label class="form-label">

                                COA
                            </label>

                            <select
                                class="form-select"
                                name="coa_id"
                                required>

                                <option
                                    disabled
                                    selected>

                                    Pilih COA
                                </option>

                                {{-- Loop COA --}}
                                @foreach($coas as $coa)

                                <option
                                    value="{{ $coa->id }}">

                                    {{ $coa->name }}
                                </option>

                                @endforeach
                            </select>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="col-md-12">

                            <label class="form-label">

                                Deskripsi
                            </label>

                            <textarea
                                class="form-control"
                                name="description">
                            </textarea>
                        </div>

                        {{-- Debit --}}
                        <div class="col-md-6">

                            <label class="form-label">

                                Debit
                            </label>

                            <input
                                type="number"
                                class="form-control"
                                name="debit"
                                value="0">
                        </div>

                        {{-- Credit --}}
                        <div class="col-md-6">

                            <label class="form-label">

                                Credit
                            </label>

                            <input
                                type="number"
                                class="form-control"
                                name="credit"
                                value="0">
                        </div>
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
                    <button class="btn btn-success">

                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection