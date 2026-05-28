@extends('layouts.app')

@section('content')

<div class="mb-3">
    <h1 class="fw-bold mb-1">
        Dashboard
    </h1>
    <p class="text-muted mb-0">
        Welcome to Finance Profit/Loss Application
    </p>
</div>

<div class="row g-4">
    <div class="col-xl-5">
        <div class="card card-custom border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h4 class="fw-semibold mb-4">
                    Profit / Loss Chart
                </h4>
                <div class="d-flex justify-content-center align-items-center">
                    <div class="w-100" style="max-width: 386px; aspect-ratio:1/1;">
                        <canvas id="profitLossChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-7">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-custom border-0 shadow-sm h-100">
                    <div class="card-body">
                        <small class="text-muted d-block mb-2">
                            Categories
                        </small>
                        <h2 class="fw-bold mb-0">
                            {{ $totalCategories }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom border-0 shadow-sm h-100">
                    <div class="card-body">
                        <small class="text-muted d-block mb-2">
                            COA
                        </small>
                        <h2 class="fw-bold mb-0">
                            {{ $totalCoas }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom border-0 shadow-sm h-100">
                    <div class="card-body">
                        <small class="text-muted d-block mb-2">
                            Transactions
                        </small>
                        <h2 class="fw-bold mb-0">
                            {{ $totalTransactions }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom border-0 shadow-sm h-100">
                    <div class="card-body">
                        <small class="text-muted d-block mb-2">
                            Income Transactions
                        </small>
                        <h2 class="fw-bold text-success mb-0">
                            {{ $totalIncome1 }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-custom border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block mb-2">
                                    Financial Status
                                </small>
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
                            <div class="text-end">
                                <small class="text-muted d-block">
                                    Current Balance
                                </small>
                                <h5 class="fw-bold mb-0">
                                    Rp {{ number_format(abs($netIncome), 0, ',', '.') }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom border-0 shadow-sm h-100">
                    <div class="card-body">
                        <small class="text-muted d-block mb-2">
                            Expense Transactions
                        </small>
                        <h2 class="fw-bold text-danger mb-0">
                            {{ $totalExpense1 }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card card-custom border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-lg-4 mb-4 mb-lg-0">
                                <h4 class="fw-semibold mb-2">
                                    Most Used COA - Categories
                                </h4>
                                <p class="text-muted mb-0">
                                    Top frequently used chart of accounts
                                </p>
                            </div>
                            <div class="col-lg-8">
                                <div class="row g-3">
                                    @foreach($mostUsedCoas->take(3) as $coa)
                                    <div class="col-md-4">
                                        <div class="bg-light rounded-4 p-4 h-100">
                                            <div class="d-flex flex-column h-100 justify-content-between">
                                                <div>
                                                    <h5 class="fw-bold mb-1">
                                                        {{ $coa->coa_name }}
                                                    </h5>
                                                    <p class="text-muted mb-0">
                                                        {{ $coa->category_name }}
                                                    </p>
                                                </div>
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

<div class="row mt-4">
    <div class="col-12">
        <div class="card card-custom border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-semibold mb-1"> Profit / Loss Summary </h4>
                        <p class="text-muted mb-0"> Current financial overview </p>
                    </div> 
                    <a href="{{ route('reports') }}" class="btn btn-primary"> View Full Report </a>
                </div>
                <div class="row g-4">
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const totalIncome = Number("{{ $totalIncome }}");
    const totalExpense = Number("{{ $totalExpense }}");
    const ctx = document.getElementById('profitLossChart');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Income', 'Expense'],
            datasets: [{
                data: [totalIncome, totalExpense],
                backgroundColor: [
                    '#198754',
                    '#dc3545'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>

@endsection