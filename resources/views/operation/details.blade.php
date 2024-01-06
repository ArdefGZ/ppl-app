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
                <h5 class="card-title">{{$mahasiswa->nama}}</h5>
                <p class="card-text">{{$mahasiswa->angkatan}}</p>
                <p class="card-text">STATUS : {{$mahasiswa->status}}</p>
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
                                    {{$mahasiswa->nama}}
                                </p>
                                <h6>NIM</h6>
                                <p>
                                    {{$mahasiswa->NIM}}
                                </p>
                                <h6>Asal</h6>
                                <p>
                                    {{$mahasiswa->kotakab->provinsi->nama_prov}},{{$mahasiswa->kotakab->nama_kota_kab}}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Email Official</h6>
                                <p>
                                    {{$mahasiswa->email}}
                                </p>
                                <h6>Nomor Handphone</h6>
                                <p>
                                    {{$mahasiswa->no_HP}}
                                </p>
                            </div>
                        </div>
                        <!--/row-->
                    </div>
                    <div class="tab-pane" id="edit">
                        <form action="/dashboard/mahasiswa/{{$mahasiswa->NIM}}/profile/edit" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Nama Lengkap</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="{{$mahasiswa->nama}}" id="nama" name="nama">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Email</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="email" value="{{$mahasiswa->email}}" id="email" name="email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">NIM</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="{{$mahasiswa->NIM}}" id="NIM" name="NIM">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="angkatan" class="col-lg-3 col-form-label form-control-label">Angkatan</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="{{$mahasiswa->angkatan}}" id="angkatan" name="angkatan">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Asal</label>
                                <div class="col-lg-9">
                                    <select id="provinsi" name="provinsi" class="form-control" size="0">
                                        @foreach($provinsi as $prov)
                                        <option value="{{$prov->kode_prov}}" <?php echo ($mahasiswa->kotakab->provinsi->kode_prov == $prov->kode_prov) ? 'selected' : ''; ?>>{{$prov->nama_prov}}</option>
                                        @endforeach
                                    </select>
                                    <select id="kotakab" name="kotakab" class="form-control" size="0">
                                        <option value="{{$mahasiswa->kotakab->id_kota_kab}}">{{$mahasiswa->kotakab->nama_kota_kab}}</option>

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
                                <label class="col-lg-3 col-form-label form-control-label">Alamat</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="{{$mahasiswa->alamat}}" id="alamat" name="alamat">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Nomor Handphone</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="{{$mahasiswa->no_HP}}" id="hp" name="hp">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Status</label>
                                <div class="col-lg-9">
                                    <select id="status" name="status" class="form-control" size="0">
                                        <option value="AKTIF" <?php echo ($mahasiswa->status == 'AKTIF') ? 'selected' : ''; ?>>AKTIF</option>
                                        <option value="CUTI" <?php echo ($mahasiswa->status == 'CUTI') ? 'selected' : ''; ?>>CUTI</option>
                                        <option value="MENINGGAL" <?php echo ($mahasiswa->status == 'MENINGGAL') ? 'selected' : ''; ?>>MENINGGAL</option>
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