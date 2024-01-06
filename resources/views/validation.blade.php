@extends('layout')
@section('content')

<div class="col-lg-13">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <a href="/dashboard/dosen/{{$user->NIP}}">
                    <i class="fas fa-chevron-left"></i>
                </a>
                Validasi Mahasiswa
            </div>
            <ul class="nav-pill">
                <li><a href="#section1">IRS</a></li>
                <li><a href="#section2">KHS</a></li>
                <li><a href="#section3">PKL</a></li>
                <li><a href="#section4">Skripsi</a></li>
            </ul>
            <hr />
            <div class="section" id="section1" data-section="section1">
                <form action="#" method="post">
                    @csrf
                    <div class="form-group">
                        <select class="form-control form-control-rounded filter-status" id="filter-status-1" name="filter-status">
                            <option value="">-- Filter Status --</option>
                            <option value="Belum Divalidasi">Belum Divalidasi</option>
                            <option value="Sudah Divalidasi">Sudah Divalidasi</option>
                        </select>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">ID</th>
                                <th scope="col">Nama</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Semester</th>
                                <th scope="col">Status</th>
                                <th scope="col">Scan IRS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $counter = 1; @endphp
                            @foreach($irs as $ir)
                            <tr>
                                @if($ir->mahasiswa->NIP == $user->NIP)
                                <td>{{$counter++}}</td>
                                <td>{{$ir->id_irs}}</td>
                                <td>{{$ir->mahasiswa->nama}}</td>
                                <td>{{$ir->mahasiswa->NIM}}</td>
                                <td>{{$ir->smst_aktif}}</td>
                                <td>{{$ir->toStatus->status}}</td>
                                <td>
                                    <button type="button" class="btn btn-light px-5 d-flex justify-content-center align-items-center" data-toggle="modal" data-target="#exampleModalLong{{$ir->id_irs}}" style="height: 30px; width: 30px;">
                                        Lihat File
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalLong{{$ir->id_irs}}">
                                        <div class="modal-dialog" style="height: 90vh;">
                                            <div class="modal-content" style="height: 85vh;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" style="color: black;">Berkas IRS</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body" style="background-color: #555555; max-height: 70vh; overflow-y: auto; height: 70vh;">
                                                    @php
                                                    $fileExtension = pathinfo($ir->berkas_irs, PATHINFO_EXTENSION);
                                                    @endphp

                                                    @if ($fileExtension)
                                                    @if ($fileExtension == 'pdf')
                                                    <object data="{{ asset('assets/berkas_irs/' . $ir->berkas_irs) }}" type="application/pdf" width="100%" height="100%">
                                                        Your PDF viewer does not support displaying PDFs.
                                                    </object>
                                                    @elseif ($fileExtension == 'doc' || $fileExtension == 'docx')
                                                    <iframe src="{{ asset('assets/berkas_irs/' . $ir->berkas_irs) }}" width="100%" height="100%">
                                                        Your browser does not support displaying Word documents.
                                                    </iframe>
                                                    @else
                                                    <p>Unsupported file format: {{ $fileExtension }}</p>
                                                    @endif
                                                    @else
                                                    <p>File Berkas Tidak Ada</p>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    @if($ir->status == 0)
                                                    <form action="/dashboard/dosen/{{$user->NIP}}/validation/irs/{{$ir->id_irs}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary" id="validasiButton">Validasi</button>
                                                    </form>
                                                    @else
                                                    <button type="button" class="btn btn-primary" disabled>Sudah diValidasi</button>
                                                    @endif
                                                </div>

                                                <script>
                                                    // JavaScript to handle the form submission when the "Validasi" button is clicked
                                                    document.getElementById('validasiButton1').addEventListener('click', function() {
                                                        document.getElementById('validasiForm1').submit();
                                                    });
                                                </script>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section 2 content -->
            <div class="section" id="section2" data-section="section2">
                <div class="form-group">
                    <select class="form-control form-control-rounded filter-status" id="filter-status-2" name="filter-status">
                        <option value="">-- Filter Status --</option>
                        <option value="Belum Divalidasi">Belum Divalidasi</option>
                        <option value="Sudah Divalidasi">Sudah Divalidasi</option>
                    </select>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">ID</th>
                                <th scope="col">Nama</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Semester</th>
                                <th scope="col">IP Semester</th>
                                <th scope="col">Status</th>
                                <th scope="col">Scan KHS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $counter = 1; @endphp
                            @foreach($khs as $k)
                            <tr>
                                @if($k->mahasiswa->NIP == $user->NIP)
                                <td>{{$counter++}}</td>
                                <td>{{$k->id_khs}}</td>
                                <td>{{$k->mahasiswa->nama}}</td>
                                <td>{{$k->NIM}}</td>
                                <td>{{$k->smt_aktif}}</td>
                                <td>{{$k->IP_smt}}</td>
                                @if($k->status == 1)
                                <td>Sudah divalidasi</td>
                                @else
                                <td>Belum divalidasi</td>
                                @endif
                                <td>
                                    <button type="button" class="btn btn-light btn-round px-2 d-flex justify-content-center align-items-center" data-toggle="modal" data-target="#exampleModalLong{{$k->id_khs}}">Lihat File</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalLong{{$k->id_khs}}">
                                        <div class="modal-dialog" style="height: 90vh;">
                                            <div class="modal-content" style="height: 85vh;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" style="color: black;">Berkas KHS</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body" style="background-color: #555555; max-height: 70vh; overflow-y: auto; height: 70vh;">
                                                    @php
                                                    $fileExtension = pathinfo($k->berkas_KHS, PATHINFO_EXTENSION);
                                                    @endphp

                                                    @if ($fileExtension == 'pdf')
                                                    <object data="{{ asset('assets/berkas_khs/' . $k->berkas_KHS) }}" type="application/pdf" width="100%" height="100%">
                                                        Your browser does not support displaying PDFs.
                                                    </object>
                                                    @elseif ($fileExtension == 'doc' || $fileExtension == 'docx')
                                                    <iframe src="{{ asset('assets/berkas_khs/' . $k->berkas_KHS) }}" width="100%" height="100%">
                                                        Your browser does not support displaying Word documents.
                                                    </iframe>
                                                    @else
                                                    <p>File berkas tidak ada</p>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    @if($k->status == 0)
                                                    <form action="/dashboard/dosen/{{$user->NIP}}/validation/khs/{{$k->id_khs}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary" id="validasiButton">Validasi</button>
                                                    </form>
                                                    @else
                                                    <button type="button" class="btn btn-primary" disabled>Sudah diValidasi</button>
                                                    @endif
                                                </div>

                                                <script>
                                                    // JavaScript to handle the form submission when the "Validasi" button is clicked
                                                    document.getElementById('validasiButton2').addEventListener('click', function() {
                                                        document.getElementById('validasiForm2').submit();
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section 3 content -->
            <div class="section" id="section3">
                <!-- Content for section 3 -->
                <h4 class="text-center"><i class="zmdi zmdi-group-work"></i> Validasi PKL</h4>
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Berita Acara PKL</th>
                                <th class="text-center">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $counter = 1; @endphp
                            @foreach($pkl as $p)
                            <tr>
                                @if($p->mahasiswa->NIP == $user->NIP)
                                <td class="text-center">{{$counter++}}</td>
                                <td class="text-center">{{$p->mahasiswa->nama}}</td>
                                <td class="text-center">{{$p->status_pkl}}</td>
                                <td class="text-center">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-light 5px" data-toggle="modal" data-target="#exampleModalLong{{$p->NIM}}">Lihat File</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalLong{{$p->NIM}}">
                                        <div class="modal-dialog" style="height: 90vh;">
                                            <div class="modal-content" style="height: 85vh;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" style="color: black;">Berkas PKL</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body" style="max-height: 70vh; overflow-y: auto; height: 70vh;">
                                                    @php
                                                    $fileExtension = pathinfo($p->berkas, PATHINFO_EXTENSION);
                                                    @endphp

                                                    @if ($fileExtension == 'pdf')
                                                    <object data="{{ asset('assets/berkas_pkl/' . $p->berkas) }}" type="application/pdf" width="100%" height="100%">
                                                        Your browser does not support displaying PDFs.
                                                    </object>
                                                    @elseif ($fileExtension == 'doc' || $fileExtension == 'docx')
                                                    <iframe src="{{ asset('assets/berkas_pkl/' . $p->berkas) }}" width="100%" height="100%">
                                                        Your browser does not support displaying Word documents.
                                                    </iframe>
                                                    @else
                                                    <p>Unsupported file format.</p>
                                                    @endif

                                                    <div class="container">
                                                        <label for="nilai_pkl" style="color: black;">Nilai PKL</label>
                                                        <h4 style="color: black;">{{$p->nilai_pkl}}</h4>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    @if($p->status_pkl == 'sedang ambil' || $p->status_pkl == 'SEGERA DIREVISI')
                                                    <form action="/dashboard/dosen/{{$user->NIP}}/validation/pkl/{{$p->NIM}}/tolak" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger" id="tolakButton">Tolak</button>
                                                    </form>
                                                    <form action="/dashboard/dosen/{{$user->NIP}}/validation/pkl/{{$p->NIM}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary" id="validasiButton">Validasi</button>
                                                    </form>
                                                    @elseif($p->status_pkl == 'lulus')
                                                    <button type="button" class="btn btn-primary" disabled>Sudah diValidasi</button>
                                                    @else
                                                    <button type="button" class="btn btn-primary" disabled>Belum diambil</button>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @if($p->status_pkl == 'lulus')
                                <td class="text-center">{{$p->nilai_pkl}}</td>
                                @else
                                <td class="text-center">-</td>
                                @endif
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section 4 content -->
            <div class="section" id="section4">
                <!-- Content for section 4 -->
                <h4 class="text-center"><i class="zmdi zmdi-graduation-cap"></i> Validasi Skripsi</h4>
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Berita Acara Sidang</th>
                                <th class="text-center">Nilai</th>
                                <th class="text-center">Tanggal Sidang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $counter = 1; @endphp
                            @foreach($skripsi as $s)
                            <tr>
                                @if($s->mahasiswa != NULL)
                                @if($s->mahasiswa->NIP == $user->NIP)
                                <td class="text-center">{{$counter++}}</td>
                                <td class="text-center">{{$s->mahasiswa->nama}}</td>
                                <td class="text-center">{{$s->status_skripsi}}</td>
                                <td class="text-center">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-light 5px" data-toggle="modal" data-target="#exampleModalLongS{{$s->NIM}}">Lihat File</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalLongS{{$s->NIM}}">
                                        <div class="modal-dialog" style="height: 90vh;">
                                            <div class="modal-content" style="height: 85vh;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" style="color: black;">Berkas Skripsi</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body" style="max-height: 70vh; overflow-y: auto; height: 70vh;">
                                                    @php
                                                    $fileExtension = pathinfo($s->berkas_skripsi, PATHINFO_EXTENSION);
                                                    @endphp
                                                    @if ($fileExtension == 'pdf')
                                                    <object data="{{ asset('assets/berkas_skripsi/' . $s->berkas_skripsi) }}" type="application/pdf" width="100%" height="100%">
                                                        Your browser does not support displaying PDFs.
                                                    </object>
                                                    @elseif ($fileExtension == 'doc' || $fileExtension == 'docx')
                                                    <iframe src="{{ asset('assets/berkas_skripsi/' . $s->berkas_skripsi) }}" width="100%" height="100%">
                                                        Your browser does not support displaying Word documents.
                                                    </iframe>
                                                    @else
                                                    <p style="color:black;">Unsupported file format. {{$s->berkas_skripsi}}</p>
                                                    @endif

                                                    <div class="container">
                                                        <label for="nilai_skripsi" style="color: black;">Nilai Skripsi</label>
                                                        <h4 style="color: black;">{{$s->nilai_skripsi}}</h4>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    @if($s->status_skripsi == 'sedang ambil' || $s->status_skripsi == 'SEGERA DIREVISI')
                                                    <form action="/dashboard/dosen/{{$user->NIP}}/validation/skripsi/{{$s->NIM}}/tolak" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger" id="tolakButton">Tolak</button>
                                                    </form>
                                                    <form action="/dashboard/dosen/{{$user->NIP}}/validation/skripsi/{{$s->NIM}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary" id="validasiButton">Validasi</button>
                                                    </form>
                                                    @elseif($s->status_skripsi == 'lulus')
                                                    <button type="button" class="btn btn-primary" disabled>Sudah diValidasi</button>
                                                    @else
                                                    <button type="button" class="btn btn-primary" disabled>Belum diambil</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @if($s->status_skripsi == 'lulus')
                                <td class="text-center">{{$s->nilai_skripsi}}</td>
                                <td class="text-center">{{$s->tanggal_sidang}}</td>
                                @else
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                @endif
                                @endif
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const filterSelects = document.querySelectorAll('.filter-status');

                    filterSelects.forEach((filterSelect) => {
                        filterSelect.addEventListener('change', function() {
                            const selectedValue = this.value.trim().toLowerCase();
                            const sectionId = this.closest('.section').getAttribute('data-section');
                            const section = document.getElementById(sectionId);
                            const tableRows = section.querySelectorAll('tbody tr');

                            tableRows.forEach((row) => {
                                const statusColumn = row.querySelector('td:nth-child(6)'); // Adjust column index as needed
                                const rowStatus = statusColumn.textContent.trim().toLowerCase();

                                if (selectedValue === '' || rowStatus === selectedValue) {
                                    row.style.display = 'table-row';
                                } else {
                                    row.style.display = 'none';
                                }
                            });
                        });
                    });

                    // JavaScript to show/hide sections when tabs are clicked
                    const navPills = document.querySelectorAll('.nav-pill a');
                    const sections = document.querySelectorAll('.section');

                    function showSection(index) {
                        // Hide all sections
                        sections.forEach((section) => {
                            section.style.display = 'none';
                        });
                        // Show the selected section
                        sections[index].style.display = 'block';
                    }

                    navPills.forEach((pill, index) => {
                        pill.addEventListener('click', (e) => {
                            e.preventDefault();
                            showSection(index);
                            // Save the selected section to local storage
                            localStorage.setItem('selectedSection', index);
                        });
                    });

                    // Check local storage for the selected section
                    const selectedSection = localStorage.getItem('selectedSection');
                    if (selectedSection !== null) {
                        showSection(parseInt(selectedSection, 10));
                    } else {
                        // If no selection is found, show the first section
                        showSection(0);
                    }
                });
            </script>
        </div>

    </div>
</div>

@endsection