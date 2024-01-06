@extends('layout')

@section('content')
<div class="card mt-3">
    <div class="card-content">
        <div class="row row-group m-0">
            @php
            // Assuming $user->NIP is the advisor's NIP
            $totalMahasiswa = \App\Models\Mahasiswa::where('NIP', $user->NIP)->count();
            $totalLulusSkripsi = \App\Models\Mahasiswa::where('NIP', $user->NIP)
            ->whereHas('skripsi', function ($query) {
            $query->where('status_skripsi', 'lulus');
            })->count();
            $totalLulusPKL = \App\Models\Mahasiswa::where('NIP', $user->NIP)
            ->whereHas('pkl', function ($query) {
            $query->where('status_pkl', 'lulus');
            })->count();
            $rerataIPK = round(\App\Models\KHS::avg('IP_Kumulatif'), 2);
            @endphp

            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0">Jumlah Mahasiswa <span class="float-right"><i class="fas fa-users"></i></span></h5>
                    <p class="mb-0 text-white small-font">{{ $totalMahasiswa}}</p>
                </div>
            </div>

            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0">Mahasiswa Lulus Skripsi <span class="float-right"><i class="fas fa-check"></i></span></h5>
                    <p class="mb-0 text-white small-font">{{ $totalLulusSkripsi }}</p>
                </div>
            </div>

            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0">Mahasiswa Lulus PKL <span class="float-right"><i class="fas fa-check"></i></span></h5>
                    <p class="mb-0 text-white small-font">{{ $totalLulusPKL }}</p>
                </div>
            </div>

            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0">Rerata IPK <span class="float-right"><i class="fas fa-book"></i></span></h5>
                    <p class="mb-0 text-white small-font">{{ $rerataIPK }}</p>
                </div>
            </div>

            <!-- Add more cards as needed for additional information -->
        </div>
    </div>
</div>
<div class="card mt-3">
    <div class="card-body">
        @php
        $ipSemesterData = [];
        $ipSemester = \App\Models\KHS::select('smt_aktif', DB::raw('avg(IP_smt) as IP_Semester'))
        ->whereHas('mahasiswa', function ($query) use ($user) {
        $query->where('NIP', $user->NIP);
        })
        ->groupBy('smt_aktif')
        ->get();
        foreach ($ipSemester as $ip) {
        $ipSemesterData[] = $ip->IP_Semester;
        }
        @endphp
        <div class="chart-container-1" style="position: relative; height:400px; width:100%;">
            <canvas id="ipSemesterChart" data-ip-semester="{{ json_encode($ipSemesterData) }}"></canvas>
        </div>
    </div>
</div>
<div class="col-13">
    <a href="/dashboard/dosen/{{$user->NIP}}/recap"class="btn btn-light" style="width:100%;">Lihat Rekap</a>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Get context with jQuery - using jQuery's .get() method.
    var ipSemesterChartCanvas = $('#ipSemesterChart').get(0).getContext('2d');

    var ipSemesterChartData = {
        labels: ['Semester 1', 'Semester 2', 'Semester 3', 'Semester 4', 'Semester 5', 'Semester 6', 'Semester 7', 'Semester 8', 'Semester 9', 'Semester 10', 'Semester 11', 'Semester 12', 'Semester 13', 'Semester 14'],
        datasets: [{
            label: 'IP Semester Rata-rata',
            data: $('#ipSemesterChart').data('ip-semester'),
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(0, 255, 0, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(0, 255, 0, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(0, 255, 0, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(0, 255, 0, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(0, 255, 0, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(0, 255, 0, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(0, 255, 0, 1)',
            ],
            borderWidth: 1
        }]
    };

    // Create and render the chart
    var ipSemesterChart = new Chart(ipSemesterChartCanvas, {
        type: 'bar', // You can change the chart type based on your preference
        data: ipSemesterChartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'white' // Set the color of the y-axis ticks to white
                    }
                },
                x: {
                    ticks: {
                        color: 'white' // Set the color of the x-axis ticks to white
                    }
                }
            },
            plugins: {
                legend: {
                    color: 'white', // Set the color of the legend text to white
                    labels: {
                        color: 'white' // Set the color of the legend labels to white
                    }
                }
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.yLabel.toFixed(2);
                    }
                },
                backgroundColor: 'rgba(255, 255, 255, 0.7)', // Set the background color of tooltips
                titleFontColor: 'white', // Set the color of the tooltip title
                bodyFontColor: 'white' // Set the color of the tooltip body text
            }
        }
    });
</script>
@endsection