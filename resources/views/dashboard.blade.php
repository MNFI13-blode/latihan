@extends('layouts.app')

@section('content')

<!-- ================= FILTER DATE ================= -->
<div class="bg-white p-4 rounded shadow mb-6 flex justify-between items-center">

    <!-- ===== KIRI (TITLE) ===== -->
    <h2 class="text-2xl font-bold">Dashboard Analitik</h2>

    <!-- ===== KANAN (FILTER) ===== -->
    <div class="flex gap-4 items-center">

        <!-- Input tanggal mulai -->
        <div>
            <label>Dari:</label>
            <input type="date" id="startDate" class="border p-2 rounded">
        </div>

        <!-- Input tanggal akhir -->
        <div>
            <label>Sampai:</label>
            <input type="date" id="endDate" class="border p-2 rounded">
        </div>

        <!-- Tombol filter -->
        <button onclick="filterData()" class="bg-blue-500 text-white px-4 py-2 rounded">
            Filter
        </button>
    </div>
</div>

<!-- ================= CHART SECTION ================= -->
<div class="grid grid-cols-3 gap-6">

    <!-- ===== PIE CHART (Gender) ===== -->
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold mb-2">Rata-rata Gender</h3>
        <canvas id="pieChart"></canvas>
    </div>

    <!-- ===== BAR CHART (Usia + Negara) ===== -->
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold mb-2">Rata-rata Usia</h3>
        <canvas id="barChart"></canvas>

        <br>

        <h3 class="font-bold mb-2">Top Negara</h3>
        <canvas id="countryChart"></canvas>
    </div>

    <!-- ===== LAST UPDATE DATA ===== -->
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold mb-4">Last Update</h3>

        <div id="latestData" class="space-y-3 text-sm">
            <!-- diisi dari JavaScript -->
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    //Load pertama
    let pieChart;
    let barChart;

    loadChart();


    // Ambil data dari backend
    function loadChart(start = null, end = null) {
        let url = '/dashboard-data';

        if (start && end) {
            url += `?start=${start}&end=${end}`;
        }

        fetch(url)
            .then(res => res.json())
            .then(data => {
                renderPie(data.pie);
                renderBar(data.bar);
                renderCountry(data.country);
                renderLatest(data.latest);
            });
    }

    //Pie Chart (Gender)
    function renderPie(data) {
        if (pieChart) pieChart.destroy();

        pieChart = new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.data
                }]
            }
        });
    }

    // Bar Chart (Usia)
    function renderBar(data) {
        if (barChart) barChart.destroy();

        barChart = new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Jumlah Data',
                    data: data.data
                }]
            },
            options: {
                indexAxis: 'y'
            }
        });
    }

    // Country Chart
    function renderCountry(data) {
        new Chart(document.getElementById('countryChart'), {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Jumlah User',
                    data: data.data
                }]
            },
            options: {
                indexAxis: 'y'
            }
        });
    }

    // Latest Data
    function renderLatest(data) {
        const container = document.getElementById('latestData');

        let html = '';

        data.forEach(item => {
            html += `
            <div class="border-b pb-2">
                <div class="font-semibold">${item.first_name} ${item.last_name}</div>
                <div class="text-gray-500">${item.email}</div>
                <div class="text-xs text-gray-400">
                    ${new Date(item.updated_at).toLocaleString()}
                </div>
            </div>
        `;
        });

        container.innerHTML = html;
    }

    // Filter Data
    function filterData() {
        const start = document.getElementById("startDate").value;
        const end = document.getElementById("endDate").value;

        loadChart(start, end);
    }
</script>
@endsection