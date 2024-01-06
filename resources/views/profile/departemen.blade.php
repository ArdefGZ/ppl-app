@extends('layout')

@section('content')
<div class="row mt-3">
    <div class="col-lg-4">
        <div class="card profile-card-2">
            <div class="card-img-block">
                <img class="img-fluid" src="/assets/assets/images/placeholder-undip.jpg" alt="Card image cap">
            </div>
            <div class="card-body pt-5">
                <img src="/assets/assets/images/pp.png" alt="profile-image" class="profile">
                <h5 class="card-title">{{$user->departemen->Nama_departemen}}</h5>
                <p class="card-text">{{$user->departemen->angkatan}}</p>
                <p class="card-text">ID Departemen : {{$user->departemen->ID_departemen}}</p>
                <p class="card-text">Thn Berdiri : {{$user->departemen->ThnBerdiri}}</p>
                <p class="card-text">Akreditasi: {{$user->departemen->Akreditasi}}</p>
                <div class="icon-block">
                    <a href="javascript:void();"><i class="fa fa-facebook bg-facebook text-white"></i></a>
                    <a href="javascript:void();"> <i class="fa fa-twitter bg-twitter text-white"></i></a>
                    <a href="javascript:void();"> <i class="fa fa-google-plus bg-google-plus text-white"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                    <li class="nav-item">
                        <a href="javascript:void();" data-target="#profile" data-toggle="pill" class="nav-link active"><i class="icon-user"></i> <span class="hidden-xs">Profile</span></a>
                    </li>
                </ul>
                <div class="tab-content p-3">
                    <div class="tab-pane active" id="profile">
                        <h5 class="mb-3">Sejarah Singkat</h5>
                        <div class="row">
                            <div class="col-md-13">
                                <div style="text-align: justify; text-align-last: center;">
                                    <p>Pada tahun 1994 di Jurusan Matematika Universitas Diponegoro Semarang mulai memberlakukan kurikulum yang lebih mengarah pada aplikasi terapan di dunia nyata dan mengakomodasi kebutuhan pasar, sehingga kurikulum pada Jurusan Matematika Universitas Diponegoro Semarang dilakukan perubahan dengan membagi menjadi empat bidang peminatan, yaitu Matematika Murni, Matematika Terapan, Statistik, dan Ilmu Komputer.</p>
                                    <p>Pada tahun 2004, berdasarkan surat Direktorat Jenderal Pendidikan Tinggi Nomor 1365/D/T/2004 tertanggal 13 April 2004 memberikan ijin dan kewenangan kepada Universitas Diponegoro Semarang untuk menyelenggarakan pendidikan dalam bidang Ilmu Komputer (S-1 Reguler) terhitung mulai tahun ajaran 2004/2005. Pada tahun 2010 nama Ilmu Komputer, diubah menjadi Teknik Informatika sesuai dengan Surat Edaran Dikti mengenai nomenklatur program studi.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--start overlay-->
<div class="overlay toggle-menu"></div>
<!--end overlay-->
@endsection