@extends('layouts.app')

@section('content')

<!-- {{-- ===================================================== --}}
{{-- HEADER HALAMAN REPORT --}}
{{-- ===================================================== --}} -->

<div class="d-flex justify-content-between align-items-center mb-4">

    <!-- {{-- Bagian judul --}} -->
    <div>

        <!-- Judul halaman -->
        <h2>Profit / Loss Report</h2>

        <!-- Subjudul -->
        <p class="text-muted mb-0">
            Monthly financial summary
        </p>
    </div>

    <!-- {{-- Tombol action --}} -->
    <div class="d-flex gap-2">

        <!-- {{-- 
            Tombol membuka modal filter
        --}} -->
        <button
            class="btn btn-outline-primary"
            data-bs-toggle="modal"
            data-bs-target="#filterReportModal">

            Filter Report
        </button>

        <!-- {{-- 
            Tombol export excel
            
            route('profit-loss.export')
            menuju route export excel
        --}} -->
        <a
            href="{{ route('profit-loss.export') }}"
            class="btn btn-success">

            Export Excel
        </a>
    </div>
</div>

<!-- {{-- ===================================================== --}}
<!-- CARD LAPORAN -->
<!-- ===================================================== --> -->

<div class="card card-custom p-4">

    <!-- Responsive table -->
    <div class="table-responsive">

        <!-- Tabel laporan -->
        <table class="table table-bordered text-center align-middle">

            <!-- Header tabel -->
            <thead class="table-warning">
                <tr>
                    <th>Category</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>

                <!-- ===================================================== -->
                <!-- DATA INCOME -->
                <!-- ===================================================== -->

                <!-- {{-- 
                    Loop semua income
                    
                    $income berasal dari controller:
                    transaksi credit > 0
                --}} -->
                @foreach($income as $item)

                <tr class="table-success">

                    <!-- Nama COA -->
                    <td>
                        {{ $item->coa->name ?? '-' }}
                    </td>

                    <!-- Nilai income -->
                    <td>

                        <!-- {{-- 
                            number_format():
                            format rupiah
                            
                            contoh:
                            1000000 => 1.000.000
                        --}} -->
                        Rp {{ number_format($item->credit, 0, ',', '.') }}
                    </td>
                </tr>

                @endforeach

                <!-- Total income -->
                <tr class="table-success fw-bold">

                    <td>Total Income</td>

                    <td>
                        Rp {{ number_format($totalIncome, 0, ',', '.') }}
                    </td>
                </tr>

                <!-- {{-- ===================================================== --}}
                {{-- DATA EXPENSE --}}
                {{-- ===================================================== --}} -->

                <!-- {{-- 
                    Loop semua expense
                    
                    $expense berasal dari controller:
                    transaksi debit > 0
                --}} -->
                @foreach($expense as $item)

                <tr class="table-danger">

                    <!-- Nama COA -->
                    <td>
                        {{ $item->coa->name ?? '-' }}
                    </td>

                    <!-- Nilai expense -->
                    <td>
                        Rp {{ number_format($item->debit, 0, ',', '.') }}
                    </td>
                </tr>

                @endforeach

                <!-- Total expense -->
                <tr class="table-danger fw-bold">

                    <td>Total Expense</td>

                    <td>
                        Rp {{ number_format($totalExpense, 0, ',', '.') }}
                    </td>
                </tr>

                <!-- ===================================================== -->
                <!-- NET INCOME -->
                <!-- ===================================================== -->

                <tr class="table-primary fw-bold">

                    <!-- Label laba bersih -->
                    <td>Net Income</td>

                    <!-- Nilai laba bersih -->
                    <td>
                        Rp {{ number_format($netIncome, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- {{-- ===================================================== --}}
{{-- MODAL FILTER REPORT --}}
{{-- ===================================================== --}} -->

<div class="modal fade" id="filterReportModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <!-- Header modal -->
            <div class="modal-header">

                <h5 class="modal-title">
                    Filter Report
                </h5>

                <!-- Tombol close -->
                <button
                    class="btn-close"
                    data-bs-dismiss="modal"></button>
            </div>

            <!-- Body modal -->
            <div class="modal-body">

                <!-- Input start month -->
                <div class="mb-3">

                    <label class="form-label">
                        Start Month
                    </label>

                    <!-- Input bulan awal -->
                    <input
                        type="month"
                        class="form-control">
                </div>

                <!-- Input end month -->
                <div class="mb-3">

                    <label class="form-label">
                        End Month
                    </label>

                    <!-- Input bulan akhir -->
                    <input
                        type="month"
                        class="form-control">
                </div>

                <!-- Filter category -->
                <div class="mb-3">

                    <label class="form-label">
                        Category
                    </label>

                    <!-- Dropdown category -->
                    <select class="form-select">

                        <!-- Default -->
                        <option selected>
                            All Categories
                        </option>

                        <!-- Option income -->
                        <option>Income</option>

                        <!-- Option expense -->
                        <option>Expense</option>
                    </select>
                </div>
            </div>

            <!-- Footer modal -->
            <div class="modal-footer">

                <!-- Tombol close -->
                <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Close
                </button>

                <!-- Tombol apply filter -->
                <button class="btn btn-primary">

                    Apply Filter
                </button>
            </div>
        </div>
    </div>
</div>

@endsection