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
                <h5 class="card-title">{{$user->mahasiswa->nama}}</h5>
                <p class="card-text">{{$user->mahasiswa->angkatan}}</p>
                <p class="card-text">STATUS : {{$user->mahasiswa->status}}</p>
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
                    <li class="nav-item">
                        <a href="javascript:void();" data-target="#edit" data-toggle="pill" class="nav-link"><i class="icon-note"></i> <span class="hidden-xs">Edit</span></a>
                    </li>
                </ul>
                <div class="tab-content p-3">
                    <div class="tab-pane active" id="profile">
                        <h5 class="mb-3">User Profile</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Nama</h6>
                                <p>
                                    {{$user->mahasiswa->nama}}
                                </p>
                                <h6>NIM</h6>
                                <p>
                                    {{$user->NIM}}
                                </p>
                                <h6>Asal</h6>
                                <p>
                                    {{$user->mahasiswa->kotakab->provinsi->nama_prov}},{{$user->mahasiswa->kotakab->nama_kota_kab}}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Email Official</h6>
                                <p>
                                    {{$user->user}}
                                </p>
                                <h6>Nomor Handphone</h6>
                                <p>
                                    {{$user->mahasiswa->no_HP}}
                                </p>
                            </div>
                        </div>
                        <!--/row-->
                    </div>
                    <div class="tab-pane" id="edit">
                        <form action="/dashboard/mahasiswa/{{$user->NIM}}/profile/edit" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Nama Lengkap <span class="text-danger">Tidak bisa diubah</span></label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="{{$user->mahasiswa->nama}}" disabled id="nama" name="nama">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Email <span class="text-danger">Tidak bisa diubah</span></label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="email" value="{{$user->user}}" disabled id="email" nama="email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">NIM <span class="text-danger">Tidak bisa diubah</span></label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="{{$user->NIM}}" disabled id="NIM" name="NIM">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="angkatan" class="col-lg-3 col-form-label form-control-label">Angkatan <span class="text-danger">Tidak bisa diubah</span></label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="{{$user->mahasiswa->angkatan}}" id="angkatan" name="angkatan" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Asal <span class="text-danger">Tidak bisa diubah</span></label>
                                <div class="col-lg-9">
                                    <select id="provinsi" name="provinsi" class="form-control" size="0" disabled>
                                        @foreach($provinsi as $prov)
                                        <option value="{{$prov->kode_prov}}" <?php echo ($user->mahasiswa->kotakab->provinsi->kode_prov == $prov->kode_prov) ? 'selected' : ''; ?>>{{$prov->nama_prov}}</option>
                                        @endforeach
                                    </select>
                                    <select id="kotakab" name="kotakab" class="form-control" size="0" disabled>
                                        <option value="{{$user->mahasiswa->kotakab->id_kota_kab}}">{{$user->mahasiswa->kotakab->nama_kota_kab}}</option>

                                    </select>
                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $('#provinsi').change(function(event) {
                                                var idState = this.value;
                                                $('kotakab').html('');

                                                $.ajax({
                                                    url: "/api/fetch-kotakab",
                                                    type: "POST",
                                                    dataType: "json",
                                                    data: {
                                                        kode_prov: idState,
                                                        _token: "{{csrf_token()}}"
                                                    },
                                                    success: function(response) {
                                                        $('#kotakab').html('<option value="">Pilih Kota-Kabupaten</option>');
                                                        $.each(response.kota_kab, function(index, val) {
                                                            $('#kotakab').append('<option value="' + val.kode_kota_kab + '">' + val.nama_kota_kab + '</option>');
                                                        });
                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Alamat <span class="text-danger">Tidak bisa diubah</span></label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="{{$user->mahasiswa->alamat}}" id="alamat" name="alamat" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Nomor Handphone</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="{{$user->mahasiswa->no_HP}}" id="hp" name="hp">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Status <span class="text-danger">Tidak bisa diubah</span></label>
                                <div class="col-lg-9">
                                    <select id="status" name="status" class="form-control" size="0" disabled>
                                        <option value="AKTIF" <?php echo ($user->mahasiswa->status == 'AKTIF') ? 'selected' : ''; ?>>AKTIF</option>
                                        <option value="CUTI" <?php echo ($user->mahasiswa->status == 'CUTI') ? 'selected' : ''; ?>>CUTI</option>
                                        <option value="MENINGGAL" <?php echo ($user->mahasiswa->status == 'MENINGGAL') ? 'selected' : ''; ?>>MENINGGAL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label"></label>
                                <div class="col-lg-9">
                                    <input type="reset" class="btn btn-secondary" value="Cancel">
                                    <input type="submit" class="btn btn-primary" value="Save Changes">
                                </div>
                            </div>
                        </form>
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