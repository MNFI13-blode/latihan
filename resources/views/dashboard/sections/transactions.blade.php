@extends('layouts.app')

@section('content')

<!-- {{-- ===================================================== --}}
<!-- {{-- HEADER HALAMAN TRANSACTIONS --}}
<!-- {{-- ===================================================== --}} -->

<div class="d-flex justify-content-between align-items-center mb-4">

    <!-- {{-- Judul halaman --}} -->
    <h2>Transactions</h2>

    <!-- {{-- 
        Tombol membuka modal tambah transaksi
    --}} -->
    <button
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#addTransactionModal">

        + Add Transaction
    </button>
</div>

<!-- {{-- ===================================================== --}}
<!-- {{-- CARD DATA TRANSACTION --}}
<!-- {{-- ===================================================== --}} -->

<div class="card card-custom p-4">

    <!-- {{-- Tabel transaksi --}} -->
    <table class="table table-bordered table-hover align-middle">

        <!-- {{-- Header tabel --}} -->
        <thead>
            <tr>
                <th>Date</th>
                <th>COA</th>
                <th>Description</th>
                <th>Debit</th>
                <th>Credit</th>
                <th width="220">Action</th>
            </tr>
        </thead>

        <tbody>

            <!-- {{-- 
                Loop semua transaksi
                
                @forelse:
                - jika ada data => tampilkan
                - jika kosong => tampilkan pesan kosong
            --}} -->
            @forelse($transactions as $item)

            <tr>

                <!-- {{-- Tanggal transaksi --}} -->
                <td>
                    {{ $item->date }}
                </td>

                <!-- {{-- Nama COA --}} -->
                <td>
                    {{ $item->coa->name ?? '-' }}
                </td>

                <!-- {{-- Deskripsi transaksi --}} -->
                <td>
                    {{ $item->description }}
                </td>

                <!-- {{-- Nilai debit --}} -->
                <td>

                    <!-- {{-- Format rupiah --}} -->
                    Rp {{ number_format($item->debit, 0, ',', '.') }}
                </td>

                <!-- {{-- Nilai credit --}} -->
                <td>

                    <!-- {{-- Format rupiah --}} -->
                    Rp {{ number_format($item->credit, 0, ',', '.') }}
                </td>

                <!-- {{-- Tombol action --}} -->
                <td>

                    <!-- {{-- Tombol edit --}} -->
                    <button
                        class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#editTransactionModal{{ $item->id }}">

                        Edit
                    </button>

                    <!-- {{-- Tombol delete --}} -->
                    <button
                        class="btn btn-danger btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteTransactionModal{{ $item->id }}">

                        Delete
                    </button>
                </td>
            </tr>

            <!-- {{-- ===================================================== --}}
            {{-- MODAL EDIT TRANSACTION --}}
            {{-- ===================================================== --}} -->

            <div
                class="modal fade"
                id="editTransactionModal{{ $item->id }}"
                tabindex="-1">

                <div class="modal-dialog modal-lg">

                    <div class="modal-content">

                        <!-- {{-- Form update transaction --}} -->
                        <form
                            action="/transactions/{{ $item->id }}"
                            method="POST">

                            <!-- {{-- CSRF token --}} -->
                            @csrf

                            <!-- {{-- Method PUT --}} -->
                            @method('PUT')

                            <!-- {{-- Header modal --}} -->
                            <div class="modal-header">

                                <h5 class="modal-title">
                                    Edit Transaction
                                </h5>

                                <!-- {{-- Tombol close --}} -->
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <!-- {{-- Body modal --}} -->
                            <div class="modal-body">

                                <div class="row g-3">

                                    <!-- {{-- Input tanggal --}} -->
                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Date
                                        </label>

                                        <input
                                            type="date"
                                            class="form-control"
                                            name="date"
                                            value="{{ $item->date }}"
                                            required>
                                    </div>

                                    <!-- {{-- Dropdown COA --}} -->
                                    <div class="col-md-6">

                                        <label class="form-label">
                                            COA
                                        </label>

                                        <select
                                            class="form-select"
                                            name="coa_id"
                                            required>

                                            <!-- {{-- Loop semua COA --}} -->
                                            @foreach($coas as $coa)
                                            <option
                                                value="{{ $coa->id }}">
                                                <!-- {{-- 
                                                    selected otomatis
                                                    jika coa_id sama
                                                --}}
                                                {{ $item->coa_id == $coa->id ? 'selected' : '' }} -->
                                                {{ $coa->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- {{-- Deskripsi --}} -->
                                    <div class="col-md-12">

                                        <label class="form-label">
                                            Description
                                        </label>

                                        <textarea
                                            class="form-control"
                                            name="description">{{ $item->description }}</textarea>
                                    </div>

                                    <!-- {{-- Input debit --}} -->
                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Debit
                                        </label>

                                        <input
                                            type="number"
                                            class="form-control"
                                            name="debit"
                                            value="{{ $item->debit }}">
                                    </div>

                                    <!-- {{-- Input credit --}} -->
                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Credit
                                        </label>

                                        <input
                                            type="number"
                                            class="form-control"
                                            name="credit"
                                            value="{{ $item->credit }}">
                                    </div>
                                </div>
                            </div>

                            <!-- {{-- Footer modal --}} -->
                            <div class="modal-footer">

                                <!-- {{-- Tombol close --}} -->
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">

                                    Close
                                </button>

                                <!-- {{-- Tombol update --}} -->
                                <button class="btn btn-warning">

                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- {{-- ===================================================== --}}
            {{-- MODAL DELETE TRANSACTION --}}
            {{-- ===================================================== --}} -->

            <div
                class="modal fade"
                id="deleteTransactionModal{{ $item->id }}"
                tabindex="-1">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <!-- Form delete -->
                        <form
                            action="/transactions/{{ $item->id }}"
                            method="POST">

                            <!-- CSRF token -->
                            @csrf

                            <!-- {{-- Method DELETE --}} -->
                            @method('DELETE')

                            <!-- {{-- Header modal --}} -->
                            <div class="modal-header">

                                <h5 class="modal-title text-danger">
                                    Delete Transaction
                                </h5>

                                <!-- {{-- Tombol close --}} -->
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <!-- {{-- Body modal --}} -->
                            <div class="modal-body">

                                <!-- {{-- Konfirmasi delete --}} -->
                                <p>
                                    Delete transaction
                                    <strong>{{ $item->description }}</strong> ?
                                </p>
                            </div>

                            <!-- {{-- Footer modal --}} -->
                            <div class="modal-footer">

                                <!-- {{-- Tombol cancel --}} -->
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">

                                    Cancel
                                </button>

                                <!-- {{-- Tombol delete --}} -->
                                <button class="btn btn-danger">

                                    Delete
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- {{-- Jika data kosong --}} -->
            @empty

            <tr>
                <td colspan="6" class="text-center">
                    No Transactions Found
                </td>
            </tr>

            @endforelse
        </tbody>
    </table>
</div>

<!-- ===================================================== -->
<!-- MODAL TAMBAH TRANSACTION -->
<!-- ===================================================== -->

<div class="modal fade" id="addTransactionModal" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <!-- Form tambah transaksi -->
            <form action="/transactions" method="POST">

                <!-- CSRF token -->
                @csrf

                <!-- Header modal -->
                <div class="modal-header">

                    <h5 class="modal-title">
                        Add Transaction
                    </h5>

                    <!-- {{-- Tombol close --}} -->
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>

                <!-- {{-- Body modal --}} -->
                <div class="modal-body">

                    <div class="row g-3">

                        <!-- Input tanggal -->
                        <div class="col-md-6">

                            <label class="form-label">
                                Date
                            </label>

                            <input
                                type="date"
                                class="form-control"
                                name="date"
                                required>
                        </div>

                        <!-- Dropdown COA -->
                        <div class="col-md-6">

                            <label class="form-label">
                                COA
                            </label>

                            <select
                                class="form-select"
                                name="coa_id"
                                required>

                                <!-- Option default -->
                                <option disabled selected>
                                    Choose COA
                                </option>

                                <!-- Loop data COA -->
                                @foreach($coas as $coa)

                                <option value="{{ $coa->id }}">
                                    {{ $coa->name }}
                                </option>

                                @endforeach
                            </select>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-md-12">

                            <label class="form-label">
                                Description
                            </label>

                            <textarea
                                class="form-control"
                                name="description"></textarea>
                        </div>

                        <!-- Input debit -->
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

                        <!-- Input credit -->
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

                <!-- Footer modal -->
                <div class="modal-footer">

                    <!-- Tombol close -->
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Close
                    </button>

                    <!-- Tombol save -->
                    <button class="btn btn-primary">

                        Save Transaction
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection