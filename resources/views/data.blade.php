@extends('layouts.app') {{-- Pakai layout utama --}}

@section('content')

<!-- ================= ACTION BAR ================= -->
<div class="bg-white p-4 rounded shadow mb-4 flex justify-between items-center">

    <!-- Judul halaman -->
    <h2 class="text-2xl font-bold mb-4">Manajemen Data</h2>

    <!-- ===== SEARCH FORM ===== -->
    <form method="GET">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}" {{-- biar value tetap ada setelah reload --}}
            placeholder="Cari data..."
            class="border p-2 rounded w-64"

            <!-- submit saat tekan Enter -->
        onkeypress="if(event.key==='Enter'){ this.form.submit(); }">
    </form>

    <!-- ===== ACTION BUTTON ===== -->
    <div class="flex gap-2">

        <!-- Tombol Sync -->
        <button
            id="syncBtn"
            onclick="syncData()" {{-- panggil function JS --}}
            class="bg-green-500 text-white px-4 py-2 rounded flex items-center gap-2">

            <span id="syncText">Sync Data</span>

            <!-- Spinner (hidden default) -->
            <span id="syncSpinner" class="hidden animate-spin">
                <i class="bi bi-arrow-repeat"></i>
            </span>
        </button>

    </div>
</div>

<!-- ================= LAST SYNC ================= -->
<div class="mb-4 text-sm text-gray-600">
    Last Sync:
    <span id="lastSync">
        {{-- Format tanggal pakai Carbon --}}
        {{ $lastSync ? \Carbon\Carbon::parse($lastSync)->translatedFormat('d F Y') : '-' }}
    </span>
</div>

<!-- ================= TABLE ================= -->
<div class="bg-white rounded-xl shadow p-4">

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left">

            <!-- ===== HEADER ===== -->
            <thead class="bg-gray-100">
                <tr>

                    <!-- Kolom dengan sorting -->
                    <th class="p-3 cursor-pointer" onclick="sortTable('first_name')">
                        Nama <i id="icon-first_name" class="bi bi-chevron-expand"></i>
                    </th>

                    <th class="p-3 cursor-pointer" onclick="sortTable('gender')">
                        Gender <i id="icon-gender" class="bi bi-chevron-expand"></i>
                    </th>

                    <th class="p-3 cursor-pointer" onclick="sortTable('birthday')">
                        Tanggal Lahir <i id="icon-birthday" class="bi bi-chevron-expand"></i>
                    </th>

                    <th class="p-3 cursor-pointer" onclick="sortTable('email')">
                        Email <i id="icon-email" class="bi bi-chevron-expand"></i>
                    </th>

                    <th class="p-3 cursor-pointer" onclick="sortTable('phone')">
                        Nomor HP <i id="icon-phone" class="bi bi-chevron-expand"></i>
                    </th>

                </tr>
            </thead>

            <!-- ===== DATA ===== -->
            <tbody id="dataTable">
                @foreach($users as $user)
                <tr class="border-b hover:bg-gray-50">

                    <td class="p-3">
                        {{ $user->first_name }} {{ $user->last_name }}
                    </td>

                    <td class="p-3">{{ $user->gender }}</td>

                    <td class="p-3">
                        {{-- Format tanggal --}}
                        {{ \Carbon\Carbon::parse($user->birthday)->translatedFormat('d F Y') }}
                    </td>

                    <td class="p-3">{{ $user->email }}</td>

                    <td class="p-3">{{ $user->phone }}</td>

                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <!-- ===== PAGINATION ===== -->
    <div class="mt-6 flex justify-center">
        {{ $users->links('layouts.pagination') }}
    </div>

</div>

<script>
    //Set icon sorting saat load
    document.addEventListener('DOMContentLoaded', () => {
        const url = new URL(window.location.href);

        const sort = url.searchParams.get('sort');
        const direction = url.searchParams.get('direction');

        if (sort && direction) {
            updateSortIcons(sort, direction);
        }
    });

    //Sync Data (API call)
    function syncData() {
        setSyncLoading(true);

        fetch('/users/sync', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);

                document.getElementById("lastSync").innerText =
                    new Date().toLocaleString();

                location.reload();
            })
            .catch(err => {
                alert("Sync gagal!");
                console.error(err);
            })
            .finally(() => {
                setSyncLoading(false);
            });
    }
    

    function searchData() {
        const keyword = document.getElementById("searchInput").value.toLowerCase();
        const rows = document.querySelectorAll("#dataTable tr");

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(keyword) ? "" : "none";
        });
    }

    let sortDirection = {};

    // Sorting Table
    function sortTable(field) {
        const url = new URL(window.location.href);

        let currentSort = url.searchParams.get('sort');
        let currentDir = url.searchParams.get('direction');

        let newDir = 'asc';

        if (currentSort === field) {
            newDir = currentDir === 'asc' ? 'desc' : 'asc';
        }

        url.searchParams.set('sort', field);
        url.searchParams.set('direction', newDir);

        window.location.href = url.toString();
    }

    // Update Icon Sorting
    function updateSortIcons(activeField, direction) {
        const fields = ['first_name', 'gender', 'birthday', 'email', 'phone'];

        fields.forEach(field => {
            const icon = document.getElementById(`icon-${field}`);

            if (!icon) return;

            if (field !== activeField) {
                icon.className = 'bi bi-chevron-expand';
            } else {
                if (direction === 'asc') {
                    icon.className = 'bi bi-chevron-up';
                } else {
                    icon.className = 'bi bi-chevron-down';
                }
            }
        });
    }

    // Loading State Button
    function setSyncLoading(isLoading) {
        const btn = document.getElementById('syncBtn');
        const text = document.getElementById('syncText');
        const spinner = document.getElementById('syncSpinner');

        if (isLoading) {
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');

            text.innerText = 'Syncing...';
            spinner.classList.remove('hidden');
        } else {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');

            text.innerText = 'Sync Data';
            spinner.classList.add('hidden');
        }
    }
</script>

@endsection