@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Profit / Loss Report</h2>
        <p class="text-muted mb-0">
            Monthly financial summary
        </p>
    </div>
    <div class="d-flex gap-2">
        <button
            class="btn btn-outline-primary"
            data-bs-toggle="modal"
            data-bs-target="#filterReportModal">
            Filter Report
        </button>
        <a
            href="{{ route('profit-loss.export') }}"
            class="btn btn-success">
            Export Excel
        </a>
    </div>
</div>

<div class="card card-custom p-4">
    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-warning">
                <tr>
                    <th>Category</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($income as $item)
                <tr class="table-success">
                    <td>
                        {{ $item->coa->name ?? '-' }}
                    </td>
                    <td>
                        Rp {{ number_format($item->credit, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
                <tr class="table-success fw-bold">
                    <td>Total Income</td>
                    <td>
                        Rp {{ number_format($totalIncome, 0, ',', '.') }}
                    </td>
                </tr>
                @foreach($expense as $item)
                <tr class="table-danger">
                    <td>
                        {{ $item->coa->name ?? '-' }}
                    </td>
                    <td>
                        Rp {{ number_format($item->debit, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
                <tr class="table-danger fw-bold">
                    <td>Total Expense</td>
                    <td>
                        Rp {{ number_format($totalExpense, 0, ',', '.') }}
                    </td>
                </tr>
                <tr class="table-primary fw-bold">
                    <td>Net Income</td>
                    <td>
                        Rp {{ number_format($netIncome, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="filterReportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Filter Report
                </h5>
                <button
                    class="btn-close"
                    data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">
                        Start Month
                    </label>
                    <input
                        type="month"
                        class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">
                        End Month
                    </label>
                    <input
                        type="month"
                        class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">
                        Category
                    </label>
                    <select class="form-select">
                        <option selected>
                            All Categories
                        </option>
                        <option>Income</option>
                        <option>Expense</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Close
                </button>
                <button class="btn btn-primary">
                    Apply Filter
                </button>
            </div>
        </div>
    </div>
</div>

@endsection