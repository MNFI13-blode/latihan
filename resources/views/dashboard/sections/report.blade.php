@extends('layouts.app')

@section('content')

{{-- ===================================================== --}}
{{-- HEADER HALAMAN --}}
{{-- ===================================================== --}}
<div class="d-flex justify-content-between align-items-center mb-4">

    {{-- Judul & deskripsi --}}
    <div>

        {{-- Judul halaman --}}
        <h2>
            Profit / Loss Report
        </h2>

        {{-- Deskripsi halaman --}}
        <p class="text-muted mb-0">

            Monthly financial summary
        </p>
    </div>

    {{-- =============================================== --}}
    {{-- BUTTON ACTION --}}
    {{-- =============================================== --}}
    <div class="d-flex gap-2">

        {{-- Button buka modal filter --}}
        <button
            class="btn btn-outline-primary"
            data-bs-toggle="modal"
            data-bs-target="#filterReportModal">

            Filter Report
        </button>

        {{-- Button export excel --}}
        <a
            href="{{ route('profit-loss.export') }}"
            class="btn btn-success">

            Export Excel
        </a>
    </div>
</div>

{{-- ===================================================== --}}
{{-- CARD LAPORAN --}}
{{-- ===================================================== --}}
<div class="card card-custom p-4">

    {{-- Responsive table --}}
    <div class="table-responsive">

        {{-- Table laporan --}}
        <table
            class="table table-bordered text-center align-middle">

            {{-- ========================================= --}}
            {{-- TABLE HEADER --}}
            {{-- ========================================= --}}
            <thead class="table-warning">

                <tr>

                    {{-- Nama category / akun --}}
                    <th>
                        Category
                    </th>

                    {{-- Total nominal --}}
                    <th>
                        Total
                    </th>
                </tr>
            </thead>

            {{-- ========================================= --}}
            {{-- TABLE BODY --}}
            {{-- ========================================= --}}
            <tbody>

                {{-- ===================================== --}}
                {{-- DATA INCOME --}}
                {{-- ===================================== --}}
                @foreach($income as $item)

                {{-- Row income --}}
                <tr class="table-success">

                    {{-- Nama COA --}}
                    <td>

                        {{ $item->coa->name ?? '-' }}
                    </td>

                    {{-- Nominal credit --}}
                    <td>

                        Rp
                        {{
                            number_format(
                                $item->credit,
                                0,
                                ',',
                                '.'
                            )
                        }}
                    </td>
                </tr>

                @endforeach

                {{-- ===================================== --}}
                {{-- TOTAL INCOME --}}
                {{-- ===================================== --}}
                <tr class="table-success fw-bold">

                    <td>
                        Total Income
                    </td>

                    <td>

                        Rp
                        {{
                            number_format(
                                $totalIncome,
                                0,
                                ',',
                                '.'
                            )
                        }}
                    </td>
                </tr>

                {{-- ===================================== --}}
                {{-- DATA EXPENSE --}}
                {{-- ===================================== --}}
                @foreach($expense as $item)

                {{-- Row expense --}}
                <tr class="table-danger">

                    {{-- Nama COA --}}
                    <td>

                        {{ $item->coa->name ?? '-' }}
                    </td>

                    {{-- Nominal debit --}}
                    <td>

                        Rp
                        {{
                            number_format(
                                $item->debit,
                                0,
                                ',',
                                '.'
                            )
                        }}
                    </td>
                </tr>

                @endforeach

                {{-- ===================================== --}}
                {{-- TOTAL EXPENSE --}}
                {{-- ===================================== --}}
                <tr class="table-danger fw-bold">

                    <td>
                        Total Expense
                    </td>

                    <td>

                        Rp
                        {{
                            number_format(
                                $totalExpense,
                                0,
                                ',',
                                '.'
                            )
                        }}
                    </td>
                </tr>

                {{-- ===================================== --}}
                {{-- NET INCOME --}}
                {{-- ===================================== --}}
                <tr class="table-primary fw-bold">

                    <td>
                        Net Income
                    </td>

                    <td>

                        Rp
                        {{
                            number_format(
                                $netIncome,
                                0,
                                ',',
                                '.'
                            )
                        }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ===================================================== --}}
{{-- MODAL FILTER REPORT --}}
{{-- ===================================================== --}}
<div
    class="modal fade"
    id="filterReportModal"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            {{-- ========================================= --}}
            {{-- MODAL HEADER --}}
            {{-- ========================================= --}}
            <div class="modal-header">

                <h5 class="modal-title">

                    Filter Report
                </h5>

                {{-- Button close --}}
                <button
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            {{-- ========================================= --}}
            {{-- MODAL BODY --}}
            {{-- ========================================= --}}
            <div class="modal-body">

                {{-- ===================================== --}}
                {{-- FILTER START MONTH --}}
                {{-- ===================================== --}}
                <div class="mb-3">

                    <label class="form-label">

                        Start Month
                    </label>

                    {{-- Input bulan awal --}}
                    <input
                        type="month"
                        class="form-control">
                </div>

                {{-- ===================================== --}}
                {{-- FILTER END MONTH --}}
                {{-- ===================================== --}}
                <div class="mb-3">

                    <label class="form-label">

                        End Month
                    </label>

                    {{-- Input bulan akhir --}}
                    <input
                        type="month"
                        class="form-control">
                </div>

                {{-- ===================================== --}}
                {{-- FILTER CATEGORY --}}
                {{-- ===================================== --}}
                <div class="mb-3">

                    <label class="form-label">

                        Category
                    </label>

                    {{-- Dropdown category --}}
                    <select class="form-select">

                        {{-- Default --}}
                        <option selected>

                            All Categories
                        </option>

                        {{-- Income --}}
                        <option>

                            Income
                        </option>

                        {{-- Expense --}}
                        <option>

                            Expense
                        </option>
                    </select>
                </div>
            </div>

            {{-- ========================================= --}}
            {{-- MODAL FOOTER --}}
            {{-- ========================================= --}}
            <div class="modal-footer">

                {{-- Button close --}}
                <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Close
                </button>

                {{-- Button apply filter --}}
                <button class="btn btn-primary">

                    Apply Filter
                </button>
            </div>
        </div>
    </div>
</div>

@endsection