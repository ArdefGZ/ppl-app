<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tugas Besar PPL</title>
    <!-- loader-->
    <link href="/assets/assets/css/pace.min.css" rel="stylesheet" />
    <script src="/assets/assets/js/pace.min.js"></script>
    <!--favicon-->
    <link rel="icon" href="/assets/assets/images/Logo_ITB.png" type="image/x-icon">
    <!-- Bootstrap core CSS-->
    <link href="/assets/assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- animate CSS-->
    <link href="/assets/assets/css/animate.css" rel="stylesheet" type="text/css" />
    <!-- Icons CSS-->
    <link href="/assets/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <!-- Custom Style-->
    <link href="/assets/assets/css/app-style.css" rel="stylesheet" />

</head>

<body class="bg-theme bg-theme1">

    <!-- start loader -->
    <div id="pageloader-overlay" class="visible incoming">
        <div class="loader-wrapper-outer">
            <div class="loader-wrapper-inner">
                <div class="loader"></div>
            </div>
        </div>
    </div>
    <!-- end loader -->

    <!-- Start wrapper-->
    <div id="wrapper">

        <div class="loader-wrapper">
            <div class="lds-ring">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="card card-authentication1 mx-auto my-5">
            <div class="card-body">
                <div class="card-content p-2">
                    <div class="text-center">
                        <img src="/assets/assets/images/Logo-Undip.png" alt="logo icon" width="80" height="90">
                    </div>
                    <div class="card-title text-uppercase text-center py-3">Perbarui Akun</div>
                    <form action="/dashboard/mahasiswa/{{$user->NIM}}/updateAcc/confirm" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama <span class="text-danger">Tidak bisa diubah</span></label>
                            <input type="text" class="form-control form-control-rounded" id="nama" name="nama" value="{{$user->mahasiswa->nama}}" disabled />
                        </div>
                        <div class="form-group">
                            <label for="nim">Nomor Induk Mahasiswa <span class="text-danger">Tidak bisa diubah</span></label>
                            <input type="text" class="form-control form-control-rounded" id="nim" name="nim" value="{{$user->NIM}}" disabled />
                        </div>
                        <div class="form-group">
                            <label for="angkatan">Angkatan <span class="text-danger">Tidak bisa diubah</span></label>
                            <input type="text" class="form-control form-control-rounded" id="angkatan" name="angkatan" value="{{$user->mahasiswa->angkatan}}" disabled />
                        </div>
                        <div class="form-group">
                            <label for="doswal">Dosen Wali <span class="text-danger">Tidak bisa diubah</span></label>
                            <input type="text" class="form-control form-control-rounded" id="doswal" name="doswal" value="{{$user->mahasiswa->doswal->nama}}" disabled />
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control form-control-rounded" id="username" name="username" placeholder="Enter Your Email Address" value="{{$user->user}}" />
                        </div>
                        <div class="form-group">
                            <label for="provinsi">Provinsi</label>
                            <select class="form-control form-control-rounded" id="provinsi" name="provinsi">
                                <option value="">Pilih Provinsi</option>
                                @foreach($prov as $state)
                                <option value="{{$state->kode_prov}}" @if(old('provinsi')==$state->kode_prov) selected @endif>{{$state->nama_prov}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="kotakab">Kota-Kabupaten</label>
                            <select class="form-control form-control-rounded" id="kotakab" name="kotakab">

                            </select>
                        </div>

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
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control form-control-rounded" id="alamat" name="alamat" placeholder="Enter Address" />
                        </div>
                        <div class="form-group">
                            <label for="noHP">Nomor Handphone</label>
                            <input type="text" class="form-control form-control-rounded" id="noHP" name="noHP" placeholder="Enter Phone Number" />
                        </div>
                        <div class="form-group">
                            <label for="jalur_masuk">Jalur Masuk</label>
                            <select class="form-control form-control-rounded" id="jalur_masuk" name="jalur_masuk">
                                <option value="">Pilih Jalur Masuk</option>
                                <option value="SNMPTN">SNMPTN</option>
                                <option value="SBMPTN">SBMPTN</option>
                                <option value="Mandiri">Mandiri</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Ubah Password</label>
                            <input type="password" class="form-control form-control-rounded" id="password" name="password" placeholder="Enter Password" />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-light btn-round px-5">
                                <i class="icon-lock"></i>
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Start Back To Top Button-->
        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
        <!--End Back To Top Button-->

        <!--start color switcher-->
        <div class="right-sidebar">
            <div class="switcher-icon">
                <i class="zmdi zmdi-settings zmdi-hc-spin"></i>
            </div>
            <div class="right-sidebar-content">

                <p class="mb-0">Gaussion Texture</p>
                <hr>

                <ul class="switcher">
                    <li id="theme1"></li>
                    <li id="theme2"></li>
                    <li id="theme3"></li>
                    <li id="theme4"></li>
                    <li id="theme5"></li>
                    <li id="theme6"></li>
                </ul>

                <p class="mb-0">Gradient Background</p>
                <hr>

                <ul class="switcher">
                    <li id="theme7"></li>
                    <li id="theme8"></li>
                    <li id="theme9"></li>
                    <li id="theme10"></li>
                    <li id="theme11"></li>
                    <li id="theme12"></li>
                    <li id="theme13"></li>
                    <li id="theme14"></li>
                    <li id="theme15"></li>
                </ul>

            </div>
        </div>
        <!--end color switcher-->

    </div><!--wrapper-->

    <!-- Bootstrap core JavaScript-->
    <script src="/assets/assets/js/jquery.min.js"></script>
    <script src="/assets/assets/js/popper.min.js"></script>
    <script src="/assets/assets/js/bootstrap.min.js"></script>
    @include('sweetalert::alert')
    <!-- sidebar-menu js -->
    <script src="/assets/assets/js/sidebar-menu.js"></script>

    <!-- Custom scripts -->
    <script src="/assets/assets/js/app-script.js"></script>

</body>

</html>