@extends('layouts.app')

@section('content')

<!-- {{-- ===================================================== --}}
{{-- HEADER HALAMAN --}}
{{-- ===================================================== --}} -->

<div class="d-flex justify-content-between align-items-center mb-4">

    <!-- Judul halaman -->
    <h2>Master COA</h2>

    <!-- {{-- 
        Tombol untuk membuka modal tambah COA
    --}} -->
    <button 
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#addCoaModal"
    >
        + Add COA
    </button>
</div>

<!-- {{-- ===================================================== --}}
<!-- CARD DATA COA -->
<!-- ===================================================== --> -->

<div class="card card-custom p-4">

    <!-- Tabel data COA -->
    <table class="table table-bordered table-hover align-middle">

        <!-- Header tabel -->
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th width="220">Action</th>
            </tr>
        </thead>

        <tbody>

            <!-- {{-- 
                Loop semua data COA
                
                @forelse:
                - jika data ada => tampilkan
                - jika kosong => tampilkan pesan kosong
            --}} -->
            @forelse($coas as $item)

                <tr>

                    <!-- Kode COA -->
                    <td>
                        {{ $item->code }}
                    </td>

                    <!-- Nama COA -->
                    <td>
                        {{ $item->name }}
                    </td>

                    <!-- Nama kategori -->
                    <td>

                        <!-- {{-- 
                            ?? '-' 
                            jika category kosong/null
                        --}} -->
                        {{ $item->category->name ?? '-' }}
                    </td>

                    <!-- Tombol action -->
                    <td>

                        <!-- Tombol edit -->
                        <button 
                            class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editCoaModal{{ $item->id }}"
                        >
                            Edit
                        </button>

                        <!-- Tombol delete -->
                        <button 
                            class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteCoaModal{{ $item->id }}"
                        >
                            Delete
                        </button>
                    </td>
                </tr>

                <!-- {{-- ===================================================== --}}
                {{-- MODAL EDIT COA --}}
                {{-- ===================================================== --}} -->

                <div 
                    class="modal fade"
                    id="editCoaModal{{ $item->id }}"
                    tabindex="-1"
                >
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- {{-- 
                                Form update COA
                                
                                action:
                                /coas/{id}
                            --}} -->
                            <form 
                                action="/coas/{{ $item->id }}"
                                method="POST"
                            >

                                <!-- CSRF token -->
                                @csrf

                                <!-- Ubah method POST menjadi PUT -->
                                @method('PUT')

                                <!-- Header modal -->
                                <div class="modal-header">

                                    <h5 class="modal-title">
                                        Edit COA
                                    </h5>

                                    <!-- Tombol close -->
                                    <button 
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                    ></button>
                                </div>

                                <!-- Body modal -->
                                <div class="modal-body">

                                    <!-- Input kode -->
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

                                    <!-- Input nama -->
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

                                    <!-- Dropdown category -->
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Category
                                        </label>

                                        <select 
                                            class="form-select"
                                            name="category_id"
                                            required
                                        >

                                            <!-- {{-- 
                                                Loop semua category
                                            --}} -->
                                            @foreach($categories as $category)

                                                <option 
                                                    value="{{ $category->id }}">
                                                    
                                                    <!-- {{-- 
                                                        selected:
                                                        otomatis terpilih
                                                        jika category_id sama
                                                    --}}
                                                    {{ $item->category_id == $category->id ? 'selected' : '' }} -->
                                                    {{ $category->name }}
                                                </option>

                                            @endforeach
                                        </select>
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

                                    <!-- {{-- Tombol update --}} -->
                                    <button class="btn btn-warning">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- ===================================================== -->
                <!-- MODAL DELETE COA -->
                <!-- ===================================================== -->

                <div 
                    class="modal fade"
                    id="deleteCoaModal{{ $item->id }}"
                    tabindex="-1"
                >
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- {{-- Form delete --}} -->
                            <form 
                                action="/coas/{{ $item->id }}"
                                method="POST"
                            >

                                <!-- {{-- CSRF token --}} -->
                                @csrf

                                <!-- {{-- Method DELETE --}} -->
                                @method('DELETE')

                                <!-- {{-- Header modal --}} -->
                                <div class="modal-header">

                                    <h5 class="modal-title text-danger">
                                        Delete COA
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

                                    <!-- {{-- Konfirmasi delete --}} -->
                                    <p>
                                        Delete COA 
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
                    <td colspan="4" class="text-center">
                        No COA Found
                    </td>
                </tr>

            @endforelse
        </tbody>
    </table>
</div>

<!-- ===================================================== -->
<!-- MODAL TAMBAH COA -->
<!-- ===================================================== -->

<div class="modal fade" id="addCoaModal" tabindex="-1">

    <div class="modal-dialog">
        <div class="modal-content">

            <!-- {{-- Form tambah COA --}} -->
            <form action="/coas" method="POST">

                <!-- {{-- CSRF token --}} -->
                @csrf

                <!-- {{-- Header modal --}} -->
                <div class="modal-header">

                    <h5 class="modal-title">
                        Add COA
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

                    <!-- {{-- Input kode --}} -->
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

                    <!-- {{-- Input nama --}} -->
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

                    <!-- {{-- Dropdown category --}} -->
                    <div class="mb-3">

                        <label class="form-label">
                            Category
                        </label>

                        <select 
                            class="form-select"
                            name="category_id"
                            required
                        >

                            <!-- {{-- Default option --}} -->
                            <option disabled selected>
                                Choose Category
                            </option>

                            <!-- {{-- Loop category --}} -->
                            @foreach($categories as $category)

                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>

                            @endforeach
                        </select>
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

                    <!-- {{-- Tombol save --}} -->
                    <button class="btn btn-primary">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection