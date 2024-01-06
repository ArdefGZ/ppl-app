@extends('layout')
@section('content')
<div class="col-lg-13">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <a href="/dashboard/departemen/{{$user->ID_dep}}/recap">
                    <i class="fas fa-chevron-left"></i>
                </a>
                List Mahasiswa {{$status}} {{$jenis}} Angkatan {{$angkatan}}
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Angkatan</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1; // Initialize the index variable
                        if($status == 'belum'){
                        $status = $status.' ambil';
                        } else {
                        $status = $status;
                        }
                        @endphp
                        @foreach($mahasiswa as $student)
                        @if($student->pkl != NULL)
                        @if(($student->pkl->status_pkl == $status && $student->angkatan == $angkatan))
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$student->NIM}}</td>
                            <td>{{$student->nama}}</td>
                            <td>{{$student->angkatan}}</td>
                            <td>{{$student->pkl->nilai_pkl}}</td>
                        </tr>
                        @php $i++; @endphp <!-- Increment the index variable -->
                        @endif
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection