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
    <!--ICON ITB-->
    <link rel="icon" href="/assets/assets/images/Logo_ITB.png" type="image/x-icon">
    <!-- Vector CSS -->
    <link href="/assets/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <!-- simplebar CSS-->
    <link href="/assets/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <!-- Bootstrap core CSS-->
    <link href="/assets/assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- animate CSS-->
    <link href="/assets/assets/css/animate.css" rel="stylesheet" type="text/css" />
    <!-- Icons CSS-->
    <link href="/assets/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <!-- Sidebar CSS-->
    <link href="/assets/assets/css/sidebar-menu.css" rel="stylesheet" />
    <!-- Custom Style-->
    <link href="/assets/assets/css/app-style.css" rel="stylesheet" />
    <!--Nav Pill-->
    <link href="/assets/assets/css/navpill.css" rel="stylesheet" />
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!--DropZone-->
    <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
    <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
</head>

<body class="bg-theme bg-theme1">

    <!-- Start wrapper-->
    <div id="wrapper">

        <!--Start sidebar-wrapper-->
        <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
            <div class="brand-logo">
                <a href="index.html">
                    <img src="/assets/assets/images/Logo-Undip.png" class="logo-icon" alt="logo icon">
                    @if($user->peran == 'mahasiswa')
                    <h5 class="logo-text">Mahasiswa</h5>
                    @elseif($user->peran == 'dosen')
                    <h5 class="logo-text">Dosen</h5>
                    @elseif($user->peran == 'operator')
                    <h5 class="logo-text">Operator</h5>
                    @elseif($user->peran == 'departemen')
                    <h5 class="logo-text">Departemen</h5>
                    @endif
                </a>
            </div>
            <ul class="sidebar-menu do-nicescrol">
                <li class="sidebar-header">MAIN NAVIGATION</li>
                <li>
                    @if($user->peran == 'mahasiswa')
                    <a href="/dashboard/mahasiswa/{{$user->NIM}}">
                        @else
                        <a href="/dashboard/{{$user->peran}}/{{$user->NIP}}">
                            @endif
                            <i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span>
                        </a>
                </li>
                @if($user->peran == 'mahasiswa')
                <li>
                    <a href="/dashboard/mahasiswa/{{$user->NIM}}/academic">
                        <i class="zmdi zmdi-balance"></i> <span>Akademik</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/mahasiswa/{{$user->NIM}}/profile">
                        <i class="zmdi zmdi-face"></i> <span>Profile</span>
                    </a>
                </li>
                @elseif($user->peran == 'dosen')
                <li>
                    <a href="/dashboard/dosen/{{$user->NIP}}/progress">
                        <i class="zmdi zmdi-time-interval"></i> <span>Progress</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/dosen/{{$user->NIP}}/validation">
                        <i class="zmdi zmdi-assignment-check"></i> <span>Validasi</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/dosen/{{$user->NIP}}/profile">
                        <i class="zmdi zmdi-face"></i> <span>Profile</span>
                    </a>
                </li>
                @elseif($user->peran == 'operator')
                <li>
                    <a href="/dashboard/operator/{{$user->NIP}}/manajemen">
                        <i class="zmdi zmdi-assignment-check"></i> <span>Manajemen Akun</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/operator/{{$user->NIP}}/recap">
                        <i class="zmdi zmdi-book"></i> <span>Rekap Mahasiswa</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/operator/{{$user->NIP}}/profile">
                        <i class="zmdi zmdi-face"></i> <span>Profile</span>
                    </a>
                </li>
                @elseif($user->peran == 'departemen')
                <li>
                    <a href="/dashboard/departemen/{{$user->ID_dep}}/progress">
                        <i class="zmdi zmdi-time-interval"></i> <span>Progress</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/departemen/{{$user->ID_dep}}/recap">
                        <i class="zmdi zmdi-book"></i> <span>Rekap Mahasiswa</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/departemen/{{$user->ID_dep}}/profile">
                        <i class="zmdi zmdi-face"></i> <span>Profile</span>
                    </a>
                </li>
                @endif

            </ul>

        </div>
        <!--End sidebar-wrapper-->

        <!--Start topbar header-->
        <header class="topbar-nav">
            <nav class="navbar navbar-expand fixed-top">
                <ul class="navbar-nav mr-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link toggle-menu" href="javascript:void();">
                            <i class="icon-menu menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <form class="search-bar">
                            <input type="text" class="form-control" placeholder="Enter keywords">
                            <a href="javascript:void();"><i class="icon-magnifier"></i></a>
                        </form>
                    </li>
                </ul>

                <ul class="navbar-nav align-items-center right-nav-link">
                    <li class="nav-item dropdown-lg">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
                            <i class="fa fa-envelope-open-o"></i></a>
                    </li>
                    <li class="nav-item dropdown-lg">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
                            <i class="fa fa-bell-o"></i></a>
                    </li>
                    <li class="nav-item language">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();"><i class="fa fa-flag"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item"> <i class="flag-icon flag-icon-gb mr-2"></i> English</li>
                            <li class="dropdown-item"> <i class="flag-icon flag-icon-fr mr-2"></i> French</li>
                            <li class="dropdown-item"> <i class="flag-icon flag-icon-cn mr-2"></i> Chinese</li>
                            <li class="dropdown-item"> <i class="flag-icon flag-icon-de mr-2"></i> German</li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                            <span class="user-profile"><img src="/assets/assets/images/pp.png" class="img-circle" alt="user avatar"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item user-details">
                                <a href="javaScript:void();">
                                    <div class="media">
                                        <div class="avatar"><img class="align-self-start mr-3" src="/assets/assets/images/pp.png" alt="user avatar"></div>
                                        <div class="media-body">
                                            @if($user->peran == 'mahasiswa')
                                            <h6 class="mt-2 user-title">{{$user->mahasiswa->nama}}</h6>
                                            <p class="user-subtitle">{{$user->mahasiswa->email}}</p>
                                            @elseif($user->peran == 'dosen')
                                            <h6 class="mt-2 user-title">{{$user->dosen->nama}}</h6>
                                            <p class="user-subtitle">{{$user->dosen->email}}</p>
                                            @elseif($user->peran == 'operator')
                                            <h6 class="mt-2 user-title">{{$user->operator->nama}}</h6>
                                            @elseif($user->peran == 'departemen')
                                            <h6 class="mt-2 user-title">{{$user->departemen->Nama_departemen}}</h6>
                                            <h6 class="mt-2 user-title">{{$user->user}}</h6>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><i class="icon-envelope mr-2"></i> Inbox</li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><i class="icon-wallet mr-2"></i> Account</li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><i class="icon-settings mr-2"></i> Setting</li>
                            <li class="dropdown-divider"></li>
                            <a href="/" class="dropdown-item"><i class="icon-power mr-2"></i> Logout</a>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>
        <!--End topbar header-->

        <div class="clearfix"></div>

        <div class="content-wrapper">
            <div class="container-fluid">

                <!--Start Dashboard Content-->

                @yield('content')

                <!--End Dashboard Content-->

                <!--start overlay-->
                <div class="overlay toggle-menu"></div>
                <!--end overlay-->

            </div>
            <!-- End container-fluid-->

        </div><!--End content-wrapper-->
        <!--Start Back To Top Button-->
        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
        <!--End Back To Top Button-->

        <!--Start footer-->
        <footer class="footer">
            <div class="container">
                <div class="text-center">
                    Dibuat dengan TANGISAN <i class="zmdi zmdi-mood-bad"></i>
                </div>
            </div>
        </footer>
        <!--End footer-->

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

    </div><!--End wrapper-->

    <!-- Bootstrap core JavaScript-->
    <script src="/assets/assets/js/jquery.min.js"></script>
    <script src="/assets/assets/js/popper.min.js"></script>
    <script src="/assets/assets/js/bootstrap.min.js"></script>

    <!-- simplebar js -->
    <script src="/assets/assets/plugins/simplebar/js/simplebar.js"></script>
    <!-- sidebar-menu js -->
    <script src="/assets/assets/js/sidebar-menu.js"></script>
    <!-- loader scripts -->
    <script src="/assets/assets/js/jquery.loading-indicator.js"></script>
    <!-- Custom scripts -->
    <script src="/assets/assets/js/app-script.js"></script>
    <!-- Chart js -->

    <script src="/assets/assets/plugins/Chart.js/Chart.min.js"></script>

    <!-- Index js -->
    <script src="/assets/assets/js/index.js"></script>
    @yield('scripts')


</body>

</html>