@extends('layouts.app')

@section('content')

<!-- {{-- ===================================================== --}}
{{-- HEADER DASHBOARD --}}
{{-- ===================================================== --}} -->

<div class="mb-3">

    <!-- {{-- Judul dashboard --}} -->
    <h1 class="fw-bold mb-1">
        Dashboard
    </h1>

    <!-- {{-- Deskripsi dashboard --}} -->
    <p class="text-muted mb-0">
        Welcome to Finance Profit/Loss Application
    </p>
</div>

<!-- {{-- ===================================================== --}}
{{-- SECTION DASHBOARD UTAMA --}}
{{-- ===================================================== --}} -->

<div class="row g-4">

    <!-- {{-- ===================================================== --}}
    {{-- CARD CHART PROFIT / LOSS --}}
    {{-- ===================================================== --}} -->

    <div class="col-xl-5">

        <div class="card card-custom border-0 shadow-sm h-100">

            <div class="card-body p-4">

                <!-- {{-- Judul chart --}} -->
                <h4 class="fw-semibold mb-4">
                    Profit / Loss Chart
                </h4>

                <!-- {{-- Container chart --}} -->
                <div class="d-flex justify-content-center align-items-center">

                    <div 
                        class="w-100" 
                        style="max-width: 386px; aspect-ratio:1/1;"
                    >

                        <!-- {{-- Canvas Chart.js --}} -->
                        <canvas id="profitLossChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- {{-- ===================================================== --}}
    <!-- {{-- CARD STATISTIK --}}
    <!-- {{-- ===================================================== --}} -->

    <div class="col-xl-7">

        <div class="row g-4">

            <!-- {{-- ===================================================== --}}
            {{-- TOTAL CATEGORY --}}
            {{-- ===================================================== --}} -->

            <div class="col-md-4">

                <div class="card card-custom border-0 shadow-sm h-100">

                    <div class="card-body">

                        <!-- {{-- Label --}} -->
                        <small class="text-muted d-block mb-2">
                            Categories
                        </small>

                        <!-- {{-- Total category --}} -->
                        <h2 class="fw-bold mb-0">
                            {{ $totalCategories }}
                        </h2>
                    </div>
                </div>
            </div>

            <!-- {{-- ===================================================== --}}
            {{-- TOTAL COA --}}
            {{-- ===================================================== --}} -->

            <div class="col-md-4">

                <div class="card card-custom border-0 shadow-sm h-100">

                    <div class="card-body">

                        <small class="text-muted d-block mb-2">
                            COA
                        </small>

                        {{-- Total COA --}}
                        <h2 class="fw-bold mb-0">
                            {{ $totalCoas }}
                        </h2>
                    </div>
                </div>
            </div>

            <!-- {{-- ===================================================== --}}
            {{-- TOTAL TRANSACTIONS --}}
            {{-- ===================================================== --}} -->

            <div class="col-md-4">

                <div class="card card-custom border-0 shadow-sm h-100">

                    <div class="card-body">

                        <small class="text-muted d-block mb-2">
                            Transactions
                        </small>

                        <!-- {{-- Total transaksi --}} -->
                        <h2 class="fw-bold mb-0">
                            {{ $totalTransactions }}
                        </h2>
                    </div>
                </div>
            </div>

            <!-- {{-- ===================================================== --}}
            <!-- {{-- TOTAL INCOME TRANSACTION --}}
            <!-- {{-- ===================================================== --}} -->

            <div class="col-md-3">

                <div class="card card-custom border-0 shadow-sm h-100">

                    <div class="card-body">

                        <small class="text-muted d-block mb-2">
                            Income Transactions
                        </small>

                        {{-- Total transaksi income --}}
                        <h2 class="fw-bold text-success mb-0">
                            {{ $totalIncome1 }}
                        </h2>
                    </div>
                </div>
            </div>

            <!-- {{-- ===================================================== --}}
            {{-- FINANCIAL STATUS --}}
            {{-- ===================================================== --}} -->

            <div class="col-md-6">

                <div class="card card-custom border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <!-- {{-- Status laba/rugi --}} -->
                            <div>

                                <small class="text-muted d-block mb-2">
                                    Financial Status
                                </small>

                                <!-- {{-- 
                                    Kondisi:
                                    - PROFIT
                                    - LOSS
                                    - BREAK EVEN
                                --}} -->
                                @if($netIncome > 0)

                                <h3 class="fw-bold text-success mb-0">
                                    PROFIT
                                </h3>

                                @elseif($netIncome < 0)

                                <h3 class="fw-bold text-danger mb-0">
                                    LOSS
                                </h3>

                                @else

                                <h3 class="fw-bold text-secondary mb-0">
                                    BREAK EVEN
                                </h3>

                                @endif
                            </div>

                            <!-- {{-- Current balance --}} -->
                            <div class="text-end">

                                <small class="text-muted d-block">
                                    Current Balance
                                </small>

                                <!-- {{-- 
                                    abs():
                                    memastikan angka selalu positif
                                --}} -->
                                <h5 class="fw-bold mb-0">

                                    Rp {{ number_format(abs($netIncome), 0, ',', '.') }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- {{-- ===================================================== --}}
            {{-- TOTAL EXPENSE TRANSACTION --}}
            {{-- ===================================================== --}} -->

            <div class="col-md-3">

                <div class="card card-custom border-0 shadow-sm h-100">

                    <div class="card-body">

                        <small class="text-muted d-block mb-2">
                            Expense Transactions
                        </small>

                        {{-- Total transaksi expense --}}
                        <h2 class="fw-bold text-danger mb-0">
                            {{ $totalExpense1 }}
                        </h2>
                    </div>
                </div>
            </div>

            <!-- {{-- ===================================================== --}}
            {{-- MOST USED COA --}}
            {{-- ===================================================== --}} -->

            <div class="col-12">

                <div class="card card-custom border-0 shadow-sm">

                    <div class="card-body p-4">

                        <div class="row align-items-center">

                            <!-- {{-- Judul section --}} -->
                            <div class="col-lg-4 mb-4 mb-lg-0">

                                <h4 class="fw-semibold mb-2">
                                    Most Used COA - Categories
                                </h4>

                                <p class="text-muted mb-0">
                                    Top frequently used chart of accounts
                                </p>
                            </div>

                            <!-- {{-- Card data COA --}} -->
                            <div class="col-lg-8">

                                <div class="row g-3">

                                    <!-- {{-- 
                                        Ambil 3 data teratas
                                        dari mostUsedCoas
                                    --}} -->
                                    @foreach($mostUsedCoas->take(3) as $coa)

                                    <div class="col-md-4">

                                        <div class="bg-light rounded-4 p-4 h-100">

                                            <div class="d-flex flex-column h-100 justify-content-between">

                                                <!-- {{-- Nama COA --}} -->
                                                <div>

                                                    <h5 class="fw-bold mb-1">
                                                        {{ $coa->coa_name }}
                                                    </h5>

                                                    <!-- {{-- Nama category --}} -->
                                                    <p class="text-muted mb-0">
                                                        {{ $coa->category_name }}
                                                    </p>
                                                </div>

                                                <!-- {{-- Total transaksi --}} -->
                                                <div class="mt-4">

                                                    <h3 class="fw-bold text-primary mb-0">
                                                        {{ $coa->total_transactions }}
                                                    </h3>

                                                    <small class="text-muted">
                                                        Transactions
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- {{-- ===================================================== --}}
<!-- {{-- PROFIT / LOSS SUMMARY --}}
<!-- {{-- ===================================================== --}} -->

<div class="row mt-4">

    <div class="col-12">

        <div class="card card-custom border-0 shadow-sm">

            <div class="card-body p-4">

                <!-- {{-- Header summary --}} -->
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h4 class="fw-semibold mb-1">
                            Profit / Loss Summary
                        </h4>

                        <p class="text-muted mb-0">
                            Current financial overview
                        </p>
                    </div>

                    <!-- {{-- Tombol menuju report --}} -->
                    <a 
                        href="{{ route('reports') }}"
                        class="btn btn-primary"
                    >
                        View Full Report
                    </a>
                </div>

                <!-- {{-- Card summary --}} -->
                <div class="row g-4">

                    <!-- {{-- TOTAL INCOME --}} -->
                    <div class="col-md-4">

                        <div class="bg-success bg-opacity-10 rounded-4 p-4 h-100">

                            <small class="text-success fw-semibold d-block mb-2">
                                Total Income
                            </small>

                            <h3 class="fw-bold text-success mb-0">

                                Rp {{ number_format($totalIncome, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>

                    <!-- {{-- TOTAL EXPENSE --}} -->
                    <div class="col-md-4">

                        <div class="bg-danger bg-opacity-10 rounded-4 p-4 h-100">

                            <small class="text-danger fw-semibold d-block mb-2">
                                Total Expense
                            </small>

                            <h3 class="fw-bold text-danger mb-0">

                                Rp {{ number_format($totalExpense, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>

                    <!-- {{-- NET INCOME --}} -->
                    <div class="col-md-4">

                        <div class="bg-primary bg-opacity-10 rounded-4 p-4 h-100">

                            <small class="text-primary fw-semibold d-block mb-2">
                                Net Income
                            </small>

                            <h3 class="fw-bold text-primary mb-0">

                                Rp {{ number_format($netIncome, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- {{-- ===================================================== --}}
{{-- CHART JS --}}
{{-- ===================================================== --}} -->

{{-- Import library Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    /**
     * Ambil total income dari controller
     */
    const totalIncome = Number("{{ $totalIncome }}");

    /**
     * Ambil total expense dari controller
     */
    const totalExpense = Number("{{ $totalExpense }}");

    /**
     * Ambil element canvas chart
     */
    const ctx = document.getElementById('profitLossChart');

    /**
     * Membuat pie chart menggunakan Chart.js
     */
    new Chart(ctx, {

        // Tipe chart
        type: 'pie',

        data: {

            // Label chart
            labels: ['Income', 'Expense'],

            datasets: [{

                // Data chart
                data: [totalIncome, totalExpense],

                // Warna chart
                backgroundColor: [
                    '#198754',
                    '#dc3545'
                ],

                // Ketebalan border
                borderWidth: 2
            }]
        },

        options: {

            // Responsive
            responsive: true,

            // Menjaga rasio chart
            maintainAspectRatio: false,

            plugins: {

                // Posisi legend
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>

@endsection