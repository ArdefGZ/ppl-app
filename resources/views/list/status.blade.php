@extends('layout')
@section('content')

<div class="col-lg-13">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <a href="/dashboard/departemen/{{$user->ID_dep}}/recap">
                    <i class="fas fa-chevron-left"></i>
                </a>
                List Mahasiswa {{$status}} Angkatan {{$angkatan}}
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No {{strtolower(str_replace('-', '', $status))}}</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Angkatan</th>
                            <th>Asal</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1; // Initialize the index variable
                        @endphp
                        @foreach($mahasiswa as $student)
                        @if($student->angkatan == $angkatan && strtolower($student->status) == strtolower(str_replace('-', ' ', $status)))
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$student->NIM}}</td>
                            <td>{{$student->nama}}</td>
                            <td>{{$student->angkatan}}</td>
                            <td>{{$student->kotakab->provinsi->nama_prov}}, {{$student->kotakab->nama_kota_kab}}</td>
                            <td>{{$student->alamat}}</td>
                        </tr>
                        @php $i++; @endphp <!-- Increment the index variable -->
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection