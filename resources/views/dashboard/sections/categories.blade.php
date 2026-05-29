@extends('layouts.app')

@section('content')

<!-- {{-- 
    Header halaman:
    - Judul Categories
    - Tombol tambah category
--}} -->
<div class="d-flex justify-content-between align-items-center mb-4">

    <!-- {{-- Judul halaman --}} -->
    <h2>Categories</h2>

    <!-- {{-- 
        Tombol membuka modal tambah category
        
        data-bs-toggle="modal"
        = memberitahu Bootstrap bahwa ini membuka modal
        
        data-bs-target="#addCategoryModal"
        = target modal yang dibuka
    --}} -->
    <button 
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#addCategoryModal"
    >
        + Add Category
    </button>
</div>

<!-- {{-- Card pembungkus tabel --}} -->
<div class="card card-custom p-4">

    <!-- {{-- Tabel data category --}} -->
    <table class="table table-bordered table-hover align-middle">

        <!-- {{-- Header tabel --}} -->
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th width="220">Action</th>
            </tr>
        </thead>

        <tbody>

            <!-- {{-- 
                Loop data categories
                
                @forelse:
                - jika ada data => tampilkan
                - jika kosong => masuk @empty
            --}} -->
            @forelse($categories as $item)

                <tr>

                    <!-- {{-- Nomor urut --}} -->
                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <!-- {{-- Nama category --}} -->
                    <td>
                        {{ $item->name }}
                    </td>

                    <!-- {{-- Tombol action --}} -->
                    <td>

                        <!-- {{-- Tombol edit --}} -->
                        <button 
                            class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editCategoryModal{{ $item->id }}"
                        >
                            Edit
                        </button>

                        <!-- {{-- Tombol delete --}} -->
                        <button 
                            class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteCategoryModal{{ $item->id }}"
                        >
                            Delete
                        </button>
                    </td>
                </tr>

                <!-- {{-- ===================================================== --}}
                {{-- MODAL EDIT CATEGORY --}}
                {{-- ===================================================== --}} -->

                <div 
                    class="modal fade" 
                    id="editCategoryModal{{ $item->id }}"
                    tabindex="-1"
                >
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- {{-- 
                                Form update category
                                
                                action:
                                /categories/{id}
                                
                                method:
                                PUT
                            --}} -->
                            <form 
                                action="/categories/{{ $item->id }}" 
                                method="POST"
                            >

                                <!-- {{-- Token keamanan Laravel --}} -->
                                @csrf

                                <!-- {{-- Ubah method POST menjadi PUT --}} -->
                                @method('PUT')

                                <!-- {{-- Header modal --}} -->
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Edit Category
                                    </h5>

                                    <!-- {{-- Tombol close --}} -->
                                    <button 
                                        type="button" 
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                    ></button>
                                </div>

                                <!-- {{-- Isi modal --}} -->
                                <div class="modal-body">

                                    <div class="mb-3">

                                        <!-- {{-- Label input --}} -->
                                        <label class="form-label">
                                            Category Name
                                        </label>

                                        <!-- {{-- Input nama category --}} -->
                                         <!-- {{-- Value lama category --}} -->
                                        <input 
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            value="{{ $item->name }}"
                                            required
                                        >
                                    </div>
                                </div>

                                <!-- {{-- Footer modal --}} -->
                                <div class="modal-footer">

                                    <!-- {{-- Tombol close --}} -->
                                    <button 
                                        type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal"
                                    >
                                        Close
                                    </button>

                                    <!-- {{-- Tombol submit --}} -->
                                    <button class="btn btn-warning">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- {{-- ===================================================== --}}
                {{-- MODAL DELETE CATEGORY --}}
                {{-- ===================================================== --}} -->

                <div 
                    class="modal fade"
                    id="deleteCategoryModal{{ $item->id }}"
                    tabindex="-1"
                >
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- {{-- Form delete --}} -->
                            <form 
                                action="/categories/{{ $item->id }}"
                                method="POST"
                            >

                                <!-- {{-- Token keamanan --}} -->
                                @csrf

                                <!-- {{-- Ubah method jadi DELETE --}} -->
                                @method('DELETE')

                                <!-- {{-- Header modal --}} -->
                                <div class="modal-header">

                                    <h5 class="modal-title text-danger">
                                        Delete Category
                                    </h5>

                                    <!-- {{-- Tombol close --}} -->
                                    <button 
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                    ></button>
                                </div>

                                <!-- {{-- Isi modal --}} -->
                                <div class="modal-body">

                                    <!-- {{-- Konfirmasi delete --}} -->
                                    <p>
                                        Delete category 
                                        <strong>{{ $item->name }}</strong> ?
                                    </p>
                                </div>

                                <!-- {{-- Footer modal --}} -->
                                <div class="modal-footer">

                                    <!-- {{-- Tombol cancel --}} -->
                                    <button 
                                        type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal"
                                    >
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
                    <td colspan="3" class="text-center">
                        No Categories Found
                    </td>
                </tr>

            @endforelse
        </tbody>
    </table>
</div>

<!-- {{-- ===================================================== --}}
{{-- MODAL TAMBAH CATEGORY --}}
{{-- ===================================================== --}} -->

<div class="modal fade" id="addCategoryModal" tabindex="-1">

    <div class="modal-dialog">
        <div class="modal-content">

            <!-- {{-- Form tambah category --}} -->
            <form action="/categories" method="POST">

                <!-- {{-- CSRF token --}} -->
                @csrf

                <!-- {{-- Header modal --}} -->
                <div class="modal-header">

                    <h5 class="modal-title">
                        Add Category
                    </h5>

                    <!-- {{-- Tombol close --}} -->
                    <button 
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>
                </div>

                <!-- {{-- Body modal --}} -->
                <div class="modal-body">

                    <div class="mb-3">

                        <!-- {{-- Label input --}} -->
                        <label class="form-label">
                            Category Name
                        </label>

                        <!-- {{-- Input category --}} -->
                        <input 
                            type="text"
                            class="form-control"
                            name="name"
                            placeholder="Enter category"
                            required
                        >
                    </div>
                </div>

                <!-- {{-- Footer modal --}} -->
                <div class="modal-footer">

                    <!-- {{-- Tombol close --}} -->
                    <button 
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>

                    <!-- {{-- Tombol submit --}} -->
                    <button class="btn btn-primary">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection