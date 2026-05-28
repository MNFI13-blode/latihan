@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Categories</h2>
    <button 
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#addCategoryModal"
    >
        + Add Category
    </button>
</div>

<div class="card card-custom p-4">
    <table class="table table-bordered table-hover align-middle">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th width="220">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $item)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        {{ $item->name }}
                    </td>
                    <td>
                        <button 
                            class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editCategoryModal{{ $item->id }}"
                        >
                            Edit
                        </button>
                        <button 
                            class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteCategoryModal{{ $item->id }}"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
                <div 
                    class="modal fade" 
                    id="editCategoryModal{{ $item->id }}"
                    tabindex="-1"
                >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form 
                                action="/categories/{{ $item->id }}" 
                                method="POST"
                            >
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Edit Category
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
                                            Category Name
                                        </label>
                                        <input 
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            value="{{ $item->name }}"
                                            required
                                        >
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
                    id="deleteCategoryModal{{ $item->id }}"
                    tabindex="-1"
                >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form 
                                action="/categories/{{ $item->id }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger">
                                        Delete Category
                                    </h5>
                                    <button 
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                    ></button>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        Delete category 
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
                    <td colspan="3" class="text-center">
                        No Categories Found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/categories" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        Add Category
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
                            Category Name
                        </label>
                        <input 
                            type="text"
                            class="form-control"
                            name="name"
                            placeholder="Enter category"
                            required
                        >
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