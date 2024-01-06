@extends('layout')
@section('content')
<div class="col-lg-13">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <a href="/dashboard/mahasiswa/{{$user->NIM}}">
                    <i class="fas fa-chevron-left"></i>
                </a>
                Progress Semester
            </div>
            <div class="row">
                <div class="col-lg-4 border-light">
                    <div class="card">
                        <div class="card-title">
                            <br>
                            <h5 class="text-white mb-0 text-center">Jumlah SKS</h5>
                        </div>
                        <div class="card-body">
                            <h1 class="text-center text-white mb-0">{{$khseach->sum('SKS_semester')}}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 border-light">
                    <div class="card">
                        <div class="card-title">
                            <br>
                            <h5 class="text-white mb-0 text-center">Semester</h5>
                        </div>
                        <div class="card-body">
                            @php
                            $smt_terakhir = 0;
                            if($user->mahasiswa->irs == null){
                            $smt_terakhir = 0;
                            }
                            else{
                            $smt_terakhir = \App\Models\IRS::where('NIM', $user->NIM)->orderBy('smst_aktif', 'desc')->first()->smst_aktif;
                            }
                            @endphp
                            <h1 class="text-center text-white mb-0">{{$smt_terakhir}}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 border-light">
                    <div class="card">
                        <div class="card-title">
                            <br>
                            <h5 class="text-white mb-0 text-center">IPK</h5>
                        </div>
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
                            <h1 class="text-center text-white mb-0">{{$ipk_terakhir}}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="d-flex flex-wrap justify-content-center">
                @foreach($irs as $ir)
                @if($ir->NIM == $user->NIM)
                <!-- Button trigger modal -->
                @if($mahasiswa->pkl->status_pkl == 'lulus' && $mahasiswa->pkl->smt_lulus == $ir->smst_aktif)
                <button type="button" class="btn btn-light custom-green-btn px-5 mx-1 my-2 semester-button" data-toggle="modal" data-target="#semester{{$ir->smst_aktif}}">Semester {{$ir->smst_aktif}}</button>
                @elseif($mahasiswa->skripsi->status_skripsi == 'lulus' && $mahasiswa->skripsi->smt_lulus == $ir->smst_aktif)
                <button type="button" class="btn btn-light custom-yellow-btn px-5 mx-1 my-2 semester-button" data-toggle="modal" data-target="#semester{{$ir->smst_aktif}}">Semester {{$ir->smst_aktif}}</button>
                @else
                <button type="button" class="btn btn-light px-5 mx-1 my-2 semester-button" data-toggle="modal" data-target="#semester{{$ir->smst_aktif}}">Semester {{$ir->smst_aktif}}</button>
                @endif
                <style>
                    .custom-green-btn {
                        background-color: #28a745;
                        /* Replace with your preferred shade of green */
                        color: #fff;
                        /* Set the text color to white or another contrasting color */
                        /* Add any additional styling as needed */
                    }

                    .custom-yellow-btn {
                        background-color: #ffc107;
                        /* Replace with your preferred shade of yellow */
                        color: #000;
                        /* Set the text color to black or another contrasting color */
                        /* Add any additional styling as needed */
                    }
                </style>

                <!-- Modal -->
                <div class="modal fade" id="semester{{$ir->smst_aktif}}">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="irs-tab-{{$ir->smst_aktif}}" data-toggle="pill" href="#irs{{$ir->smst_aktif}}">IRS</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="khs-tab-{{$ir->smst_aktif}}" data-toggle="pill" href="#khs{{$ir->smst_aktif}}">KHS</a>
                                    </li>
                                    @if($mahasiswa->pkl->status_pkl == 'lulus' && $mahasiswa->pkl->smt_lulus == $ir->smst_aktif)
                                    <li class="nav-item">
                                        <a class="nav-link" id="pkl-tab-{{$ir->smst_aktif}}" data-toggle="pill" href="#pkl{{$ir->smst_aktif}}">PKL</a>
                                    </li>
                                    @elseif($mahasiswa->skripsi->status_skripsi == 'lulus' && $mahasiswa->skripsi->smt_lulus == $ir->smst_aktif)
                                    <li class="nav-item">
                                        <a class="nav-link" id="skripsi-tab-{{$ir->smst_aktif}}" data-toggle="pill" href="#skripsi{{$ir->smst_aktif}}">Skripsi</a>
                                    </li>
                                    @endif
                                </ul>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>

                            @php
                            $khsPrefixLength = 3;
                            $id_khs = 'KHS' . substr($ir->id_irs, $khsPrefixLength);
                            @endphp

                            <div class="modal-body">
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="irs{{$ir->smst_aktif}}">
                                        <!-- IRS Content -->
                                        <h1 style="color: black;" class="text-center">{{$ir->jumlah_sks}} SKS</h1>
                                        <button type="button" class="btn btn-primary mx-auto d-block mt-3" data-toggle="modal" data-target="#berkas-irs{{$ir->smst_aktif}}">Berkas IRS</button>
                                    </div>
                                    <div class="tab-pane fade" id="khs{{$ir->smst_aktif}}">
                                        <!-- KHS Content -->
                                        @foreach($khs as $khsItem)
                                        @if($khsItem->id_khs == $id_khs)
                                        <table class="table table-bordered" style="color:black;">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">SKS Semester</th>
                                                    <td>{{$khsItem->SKS_semester}}</td>
                                                </tr>
                                                <tr>
                                                    <th>IP Semester</th>
                                                    <td>{{$khsItem->IP_smt}}</td>
                                                </tr>
                                                <tr>
                                                    <th>SKS Kumulatif</th>
                                                    <td>{{$khsItem->SKS_kumulatif}}</td>
                                                </tr>
                                                <tr>
                                                    <th>IP Kumulatif</th>
                                                    <td>{{$khsItem->IP_Kumulatif}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-primary mx-auto d-block mt-3" data-toggle="modal" data-target="#berkas-khs{{$khsItem->smt_aktif}}">Berkas KHS</button>
                                        @endif
                                        @endforeach
                                    </div>
                                    <div class="tab-pane fade" id="pkl{{$ir->smst_aktif}}">
                                        <!-- PKL Content -->
                                        <h4 style="color: black;" class="text-center">Nilai</h4>
                                        <h1 style="color: black;" class="text-center">{{$mahasiswa->pkl->nilai_pkl}}</h1>
                                        <button type="button" class="btn btn-primary mx-auto d-block mt-3" data-toggle="modal" data-target="#berkas-pkl">Berkas PKL</button>
                                    </div>
                                    <div class="tab-pane fade" id="skripsi{{$ir->smst_aktif}}">
                                        <!-- Skrispi Content -->
                                        <h4 style="color: black;" class="text-center">Nilai</h4>
                                        <h1 style="color: black;" class="text-center">{{$mahasiswa->skripsi->nilai_skripsi}}</h1>
                                        <button type="button" class="btn btn-primary mx-auto d-block mt-3" data-toggle="modal" data-target="#berkas-skripsi">Berkas Skripsi</button>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <h7 id="irs-content-{{$ir->smst_aktif}}" style="color: black;">{{$ir->id_irs}}</h7>
                                <h7 id="khs-content-{{$ir->smst_aktif}}" style="color: black; display:none;">{{$id_khs}}</h7>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Berkas IRS -->
                <div class="modal fade" id="berkas-irs{{$ir->smst_aktif}}">
                    <div class="modal-dialog" style="height: 100vh;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <!-- Your header content here -->
                                <h4 style="color: black;" class="modal-title">Berkas IRS</h4>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <!-- Your body content here -->
                                @php
                                $fileExtension = pathinfo($ir->berkas_irs, PATHINFO_EXTENSION);
                                @endphp
                                <h7 style="color: black;" class="modal-title">{{$ir->berkas_irs}}</h7>
                                @if ($fileExtension == 'pdf')
                                <object data="{{ asset('assets/berkas_irs/' . $ir->berkas_irs) }}" type="application/pdf" width="100%" height="100%">
                                    Your browser does not support displaying PDFs.
                                </object>
                                @elseif ($fileExtension == 'doc' || $fileExtension == 'docx')
                                <iframe src="{{ asset('assets/berkas_irs/' . $ir->berkas_irs) }}" width="100%" height="100%">
                                    Your browser does not support displaying Word documents.
                                </iframe>
                                @else
                                <p>Unsupported file format.</p>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Berkas KHS -->
                @foreach($khs as $khsItem)
                @if($khsItem->id_khs == $id_khs)
                <div class="modal fade" id="berkas-khs{{$khsItem->smt_aktif}}">
                    <div class="modal-dialog" style="height: 100vh;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <!-- Your header content here -->
                                <h4 style="color: black;" class="modal-title">Berkas KHS</h4>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <!-- Your body content here -->
                                @php
                                $fileExtension = pathinfo($khsItem->berkas_khs, PATHINFO_EXTENSION);
                                @endphp
                                <h7 style="color: black;" class="modal-title">{{$khsItem->berkas_khs}}</h7>
                                @if ($fileExtension == 'pdf')
                                <object data="{{ asset('assets/berkas_khs/' . $khsItem->berkas_khs) }}" type="application/pdf" width="100%" height="100%">
                                    Your browser does not support displaying PDFs.
                                </object>
                                @elseif ($fileExtension == 'doc' || $fileExtension == 'docx')
                                <iframe src="{{ asset('assets/berkas_khs/' . $khsItem->berkas_khs) }}" width="100%" height="100%">
                                    Your browser does not support displaying Word documents.
                                </iframe>
                                @else
                                <p>Unsupported file format.</p>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach

                <!-- Modal for Berkas PKL -->
                <div class="modal fade" id="berkas-pkl">
                    <div class="modal-dialog" style="height: 100vh;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <!-- Your header content here -->
                                <h4 style="color: black;" class="modal-title">Berkas PKL</h4>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <!-- Your body content here -->
                                @php
                                $fileExtension = pathinfo($mahasiswa->pkl->berkas, PATHINFO_EXTENSION);
                                @endphp
                                <h7 style="color: black;" class="modal-title">{{$mahasiswa->pkl->berkas}}</h7>
                                @if ($fileExtension == 'pdf')
                                <object data="{{ asset('assets/berkas_pkl/' . $mahasiswa->pkl->berkas) }}" type="application/pdf" width="100%" height="100%">
                                    Your browser does not support displaying PDFs.
                                </object>
                                @elseif ($fileExtension == 'doc' || $fileExtension == 'docx')
                                <iframe src="{{ asset('assets/berkas_pkl/' . $mahasiswa->pkl->berkas) }}" width="100%" height="100%">
                                    Your browser does not support displaying Word documents.
                                </iframe>
                                @else
                                <p>Unsupported file format.</p>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal for Berkas Skripsi -->
                <div class="modal fade" id="berkas-skripsi">
                    <div class="modal-dialog" style="height: 100vh;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 style="color: black;" class="modal-title">Berkas Skripsi</h4>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                @php
                                $fileExtension = pathinfo($mahasiswa->skripsi->berkas_skripsi, PATHINFO_EXTENSION);
                                @endphp
                                <h7 style="color: black;" class="modal-title">{{$mahasiswa->skripsi->berkas_skripsi}}</h7>
                                @if ($fileExtension == 'pdf')
                                <object data="{{ asset('assets/berkas_skripsi/' . $mahasiswa->skripsi->berkas_skripsi) }}" type="application/pdf" width="100%" height="100%">
                                    Your browser does not support displaying PDFs.
                                </object>
                                @elseif ($fileExtension == 'doc' || $fileExtension == 'docx')
                                <iframe src="{{ asset('assets/berkas_skripsi/' . $mahasiswa->skripsi->berkas_skripsi) }}" width="100%" height="100%">
                                    Your browser does not support displaying Word documents.
                                </iframe>
                                @else
                                <p>Unsupported file format.</p>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                    /* Custom style for inactive tabs */
                    .nav-pills .nav-item .nav-link {
                        color: black !important;
                        /* Adjust the text color for inactive tabs */
                        background-color: rgba(255, 255, 255, 1) !important;
                        /* Adjust the alpha value for transparency */
                    }

                    /* Custom style for active tab */
                    .nav-pills .nav-item .nav-link.active {
                        color: #fff !important;
                        /* Change this to the desired text color for the active tab */
                        background-color: #007bff !important;
                        /* Change this to the desired background color for the active tab */
                    }
                </style>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    // JavaScript to show/hide IRS/KHS/PKL content in modal footer
    const irsTabs = document.querySelectorAll('[id^="irs-tab"]');
    const khsTabs = document.querySelectorAll('[id^="khs-tab"]');
    const pklTabs = document.querySelectorAll('[id^="pkl-tab"]');
    const skripsiTabs = document.querySelectorAll('[id^="skripsi-tab"]');
    const irsContents = document.querySelectorAll('[id^="irs-content"]');
    const khsContents = document.querySelectorAll('[id^="khs-content"]');
    const pklContents = document.querySelectorAll('[id^="pkl-content"]');
    const skripsiContents = document.querySelectorAll('[id^="skripsi-content"]');

    function showIRSContent(index) {
        irsContents[index].style.display = 'block';
        khsContents[index].style.display = 'none';
        pklContents[index].style.display = 'none';
        skripsiContents[index].style.display = 'none';
    }

    function showKHSContent(index) {
        irsContents[index].style.display = 'none';
        khsContents[index].style.display = 'block';
        pklContents[index].style.display = 'none';
        skripsiContents[index].style.display = 'none';
    }

    function showPKLContent(index) {
        irsContents[index].style.display = 'none';
        khsContents[index].style.display = 'none';
        pklContents[index].style.display = 'block';
        skripsiContents[index].style.display = 'none';
    }

    irsTabs.forEach((irsTab, index) => {
        irsTab.addEventListener('click', () => {
            showIRSContent(index);
        });
    });

    khsTabs.forEach((khsTab, index) => {
        khsTab.addEventListener('click', () => {
            showKHSContent(index);
        });
    });

    pklTabs.forEach((pklTab, index) => {
        pklTab.addEventListener('click', () => {
            showPKLContent(index);
        });
    });

    skripsiTabs.forEach((skripsiTab, index) => {
        skripsiTab.addEventListener('click', () => {
            showSkripsiContent(index);
        });
    });
</script>
@endsection