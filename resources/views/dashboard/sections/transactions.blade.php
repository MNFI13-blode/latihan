@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Transactions</h2>
    <button
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#addTransactionModal">
        + Add Transaction
    </button>
</div>
<div class="card card-custom p-4">
    <table class="table table-bordered table-hover align-middle">
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
            @forelse($transactions as $item)
            <tr>
                <td>
                    {{ $item->date }}
                </td>
                <td>
                    {{ $item->coa->name ?? '-' }}
                </td>
                <td>
                    {{ $item->description }}
                </td>
                <td>
                    Rp {{ number_format($item->debit, 0, ',', '.') }}
                </td>
                <td>
                    Rp {{ number_format($item->credit, 0, ',', '.') }}
                </td>
                <td>
                    <button
                        class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#editTransactionModal{{ $item->id }}">
                        Edit
                    </button>
                    <button
                        class="btn btn-danger btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteTransactionModal{{ $item->id }}">
                        Delete
                    </button>
                </td>
            </tr>
            <div
                class="modal fade"
                id="editTransactionModal{{ $item->id }}"
                tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form
                            action="/transactions/{{ $item->id }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    Edit Transaction
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
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
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            COA
                                        </label>
                                        <select
                                            class="form-select"
                                            name="coa_id"
                                            required>
                                            @foreach($coas as $coa)
                                            <option
                                                value="{{ $coa->id }}"
                                                {{ $item->coa_id == $coa->id ? 'selected' : '' }}>
                                                {{ $coa->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">
                                            Description
                                        </label>
                                        <textarea
                                            class="form-control"
                                            name="description">{{ $item->description }}</textarea>
                                    </div>
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
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button class="btn btn-warning">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div
                class="modal fade"
                id="deleteTransactionModal{{ $item->id }}"
                tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form
                            action="/transactions/{{ $item->id }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-header">
                                <h5 class="modal-title text-danger">
                                    Delete Transaction
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    Delete transaction
                                    <strong>{{ $item->description }}</strong> ?
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button class="btn btn-danger">
                                    Delete
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
<div class="modal fade" id="addTransactionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/transactions" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        Add Transaction
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
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
                        <div class="col-md-6">
                            <label class="form-label">
                                COA
                            </label>
                            <select
                                class="form-select"
                                name="coa_id"
                                required>
                                <option disabled selected>
                                    Choose COA
                                </option>
                                @foreach($coas as $coa)
                                <option value="{{ $coa->id }}">
                                    {{ $coa->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">
                                Description
                            </label>
                            <textarea
                                class="form-control"
                                name="description"></textarea>
                        </div>
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
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Close
                    </button>
                    <button class="btn btn-primary">
                        Save Transaction
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection