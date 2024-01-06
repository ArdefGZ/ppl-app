@extends('layout')
@section('content')
<div class="card mt-3">
    <div class="card-content">
        <div class="row row-group m-0">
            <div class="col-12 col-lg-6 col-xl-3 border-light">

                <div class="card-body">
                    <h5 class="text-white mb-0">{{ ucwords($user->mahasiswa->pkl->status_pkl) }} <span class="float-right"><i class="fa fa-building"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:55%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Status PKL </p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0">
                        {{ ucwords($user->mahasiswa->skripsi->status_skripsi) }}
                        <span class="float-right"><i class="fa fa-book"></i></span>
                    </h5>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:55%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Status Skripsi</p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h5 class="text-white mb-0">{{$user->mahasiswa->status}} <span class="float-right"><i class="fa fa-eye"></i></span></h5>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:55%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Status Aktif </p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    <h7 class="text-white mb-0">{{$user->mahasiswa->doswal->nama}} <span class="float-right"><i class="fa fa-chalkboard-teacher"></i></span></h7>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:55%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Dosen Wali </p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    @php
                    $ipk_terakhir = 0;
                    if($user->mahasiswa->khs == null){
                    $ipk_terakhir = 0;
                    }
                    else{
                    $ipk_terakhir = \App\Models\KHS::where('NIM', $user->NIM)->orderBy('smt_aktif', 'desc')->first()->IP_Kumulatif;
                    }
                    @endphp
                    <h7 class="text-white mb-0">{{$ipk_terakhir}} <span class="float-right"><i class="fas fa-star"></i></span></h7>
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:55%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">IPK </p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    @php
                    $ips_terakhir = 0;
                    if($user->mahasiswa->khs == null){
                    $ips_terakhir = 0;
                    }
                    else{
                    $ips_terakhir = \App\Models\KHS::where('NIM', $user->NIM)->orderBy('smt_aktif', 'desc')->first()->IP_smt;
                    }
                    @endphp
                    @if($user->mahasiswa->khs != NULL)
                    <h7 class="text-white mb-0">{{$ips_terakhir}} <span class="float-right"><i class="fas fa-star-half"></i></span></h7>
                    @else
                    <h7 class="text-white mb-0">0.00 <span class="float-right"><i class="fas fa-star-half"></i></span></h7>
                    @endif
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:55%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">IP Semester</p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    @php
                    $sks_total = 0;
                    foreach($khs as $k){
                    if($k->NIM == $user->NIM){
                    $sks_total += $k->SKS_semester;
                    }
                    }
                    @endphp
                    @if($user->mahasiswa->khs != NULL)
                    <h7 class="text-white mb-0">{{$sks_total}} <span class="float-right"><i class="fas fa-piggy-bank"></i></span></h7>
                    @else
                    <h7 class="text-white mb-0">0 <span class="float-right"><i class="fas fa-piggy-bank"></i></span></h7>
                    @endif
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:55%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Jumlah SKS Kumulatif </p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                    @php
                    if($user->mahasiswa->irs == null){
                    $smt_terakhir = 0;
                    $sks_terakhir = 0;
                    }
                    else{
                    $smt_terakhir = \App\Models\IRS::where('NIM', $user->NIM)->orderBy('smst_aktif', 'desc')->first()->smst_aktif;
                    }
                    foreach($khs as $k){
                    if($k->NIM == $user->NIM && $k->smst_aktif == $smt_terakhir){
                    $sks_terakhir = $k->SKS_semester;
                    }
                    }
                    @endphp
                    @if($user->mahasiswa->irs != NULL)
                    <h7 class="text-white mb-0">{{$user->mahasiswa->irs->jumlah_sks}} <span class="float-right"><i class="fas fa-piggy-bank"></i></span></h7>
                    @else
                    <h7 class="text-white mb-0">0 <span class="float-right"><i class="fas fa-piggy-bank"></i></span></h7>
                    @endif
                    <div class="progress my-3" style="height:3px;">
                        <div class="progress-bar" style="width:55%"></div>
                    </div>
                    <p class="mb-0 text-white small-font">Jumlah SKS </p>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<a href="/dashboard/mahasiswa/{{$user->NIM}}/progress" class=" btn btn-light" style="align-items: center;">LIHAT PROGRESS SEMESTER</a>
<hr>
<div class="card mt-3">
    <div class="card-body">
        @php
        $ipSemesterData = [];
        foreach($khs as $k){
        if($k->NIM == $user->NIM){
        $ipSemesterData[] = [
        'smt_aktif' => $k->smt_aktif,
        'IP_smt' => $k->IP_smt
        ];
        }
        }
        @endphp
        <div class="chart-container-1">
            <canvas id="ipSemesterChart" data-ip-semester="{{ json_encode($ipSemesterData) }}" data-semester-label="Semester"></canvas>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('ipSemesterChart').getContext('2d');
        var ipSemesterData = JSON.parse(document.getElementById('ipSemesterChart').getAttribute('data-ip-semester'));
        var semesterLabel = document.getElementById('ipSemesterChart').getAttribute('data-semester-label');
        var labels = ipSemesterData.map(function(item) {
            return semesterLabel + ' ' + item.smt_aktif;
        });

        var data = ipSemesterData.map(function(item) {
            return item.IP_smt;
        });

        // Function to get a random color with opacity
        function getRandomColor(alpha) {
            var letters = '0123456789ABCDEF';
            var color = 'rgba(';
            for (var i = 0; i < 3; i++) {
                color += Math.floor(Math.random() * 256) + ',';
            }
            color += alpha + ')';
            return color;
        }

        var backgroundColors = ipSemesterData.map(function() {
            return getRandomColor(0.2); // Set alpha to 0.2 for opacity
        });

        var borderColors = ipSemesterData.map(function() {
            return getRandomColor(1); // Set alpha to 1 for opacity
        });

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'IP Semester',
                    data: data,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 2
                }]
            },
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
    });
</script>
@endsection