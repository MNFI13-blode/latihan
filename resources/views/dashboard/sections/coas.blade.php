@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Master COA</h2>
    <button 
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#addCoaModal"
    >
        + Add COA
    </button>
</div>
<div class="card card-custom p-4">
    <table class="table table-bordered table-hover align-middle">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th width="220">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($coas as $item)
                <tr>
                    <td>
                        {{ $item->code }}
                    </td>
                    <td>
                        {{ $item->name }}
                    </td>
                    <td>
                        {{ $item->category->name ?? '-' }}
                    </td>
                    <td>
                        <button 
                            class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editCoaModal{{ $item->id }}"
                        >
                            Edit
                        </button>
                        <button 
                            class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteCoaModal{{ $item->id }}"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
                <div 
                    class="modal fade"
                    id="editCoaModal{{ $item->id }}"
                    tabindex="-1"
                >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form 
                                action="/coas/{{ $item->id }}"
                                method="POST"
                            >
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Edit COA
                                    </h5>
                                    <button 
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                    ></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Kode
                                        </label>
                                        <input 
                                            type="text"
                                            class="form-control"
                                            name="code"
                                            value="{{ $item->code }}"
                                            required
                                        >
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Nama
                                        </label>
                                        <input 
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            value="{{ $item->name }}"
                                            required
                                        >
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Category
                                        </label>
                                        <select 
                                            class="form-select"
                                            name="category_id"
                                            required
                                        >
                                            @foreach($categories as $category)
                                                <option 
                                                    value="{{ $category->id }}"
                                                    {{ $item->category_id == $category->id ? 'selected' : '' }}
                                                >
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button 
                                        type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal"
                                    >
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
                    id="deleteCoaModal{{ $item->id }}"
                    tabindex="-1"
                >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form 
                                action="/coas/{{ $item->id }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger">
                                        Delete COA
                                    </h5>
                                    <button 
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                    ></button>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        Delete COA 
                                        <strong>{{ $item->name }}</strong> ?
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button 
                                        type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal"
                                    >
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
                    <td colspan="4" class="text-center">
                        No COA Found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="modal fade" id="addCoaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/coas" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        Add COA
                    </h5>
                    <button 
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">
                            Kode
                        </label>
                        <input 
                            type="text"
                            class="form-control"
                            name="code"
                            required
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Nama
                        </label>
                        <input 
                            type="text"
                            class="form-control"
                            name="name"
                            required
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Category
                        </label>
                        <select 
                            class="form-select"
                            name="category_id"
                            required
                        >
                            <option disabled selected>
                                Choose Category
                            </option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button 
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                    <button class="btn btn-primary">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection