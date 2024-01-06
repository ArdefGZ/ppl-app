@extends('layout')
@section('content')

<div class="col-lg-13">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                @if($user->peran == "dosen")
                <a href="/dashboard/dosen/{{$user->NIP}}">
                    @elseif($user->peran == "departemen")
                    <a href="/dashboard/departemen/{{$user->ID_dep}}">
                        @endif
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    Rekap Mahasiswa
            </div>
            <ul class="nav-pill">
                <li><a href="#section1">PKL</a></li>
                <li><a href="#section2">Skripsi</a></li>
                <li><a href="#section3">Status</a></li>
            </ul>
            <div class="section" id="section1">
                <br>
                <div class="table-responsive">
                    <table class="table" id="pkl-table">
                        <thead>
                            <tr>
                                <th class="text-center" colspan="16" scope="col">Rekap PKL Mahasiswa</th>
                            </tr>
                            <tr>
                                <th class="text-center" colspan="16" scope="col">Angkatan</th>
                            </tr>
                            <tr>
                                @for($i=2016;$i<=2023;$i++) <th class="text-center" colspan="2" scope="col">{{$i}}</th>
                                    @endfor
                            </tr>
                            <tr>
                                @for($i=0;$i<=7;$i++) <th class="text-center">Sudah</th>
                                    <th class="text-center">Belum</th>
                                    @endfor
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @for($i=2016;$i<=2023;$i++) <?php
                                                            $sudahLulusCount = 0;
                                                            $belumLulusCount = 0;
                                                            ?> @foreach($mahasiswa as $student) @if($student->angkatan == $i && $student->pkl && $student->pkl->status_pkl == 'lulus')
                                    <?php $sudahLulusCount++; ?>
                                    @endif
                                    @if($student->angkatan == $i && (!$student->pkl || $student->pkl->status_pkl != 'lulus'))
                                    <?php $belumLulusCount++; ?>
                                    @endif
                                    @endforeach
                                    @if($sudahLulusCount == 0)
                                    <td class="text-center">{{$sudahLulusCount}}</td>
                                    @else
                                    @if($user->peran == "operator")
                                    <td class="text-center"><a href="/dashboard/operator/{{$user->NIP}}/recap/{{$i}}/pkl/lulus">{{$sudahLulusCount}}</a></td>
                                    @elseif($user->peran == "departemen")
                                    <td class="text-center"><a href="/dashboard/departemen/{{$user->ID_dep}}/recap/{{$i}}/pkl/lulus">{{$sudahLulusCount}}</a></td>
                                    @endif
                                    @endif
                                    @if($belumLulusCount == 0)
                                    <td class="text-center">{{$belumLulusCount}}</td>
                                    @else
                                    @if($user->peran == "operator")
                                    <td class="text-center"><a href="/dashboard/operator/{{$user->NIP}}/recap/{{$i}}/pkl/belum">{{$belumLulusCount}}</a></td>
                                    @elseif($user->peran == "departemen")
                                    <td class="text-center"><a href="/dashboard/departemen/{{$user->ID_dep}}/recap/{{$i}}/pkl/belum">{{$belumLulusCount}}</a></td>
                                    @endif
                                    @endif
                                    @endfor
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>

            <!-- Section 2 content -->
            <div class="section" id="section2">
                <div class="table-responsive">
                    <table class="table" id="skripsi-table">
                        <thead>
                            <tr>
                                <th class="text-center" colspan="16" scope="col">Rekap Skripsi Mahasiswa</th>
                            </tr>
                            <tr>
                                <th class="text-center" colspan="16" scope="col">Angkatan</th>
                            </tr>
                            <tr>
                                @for($i=2016;$i<=2023;$i++) <th class="text-center" colspan="2" scope="col">{{$i}}</th>
                                    @endfor
                            </tr>
                            <tr>
                                @for($i=0;$i<=7;$i++) <th class="text-center">Sudah</th>
                                    <th class="text-center">Belum</th>
                                    @endfor
                            </tr>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i=2016;$i<=2023;$i++) <?php
                                                        $sudahLulusCount = 0;
                                                        $belumLulusCount = 0;
                                                        ?> @foreach($mahasiswa as $student) @if($student->angkatan == $i && $student->skripsi && $student->skripsi->status_skripsi == 'lulus')
                                <?php $sudahLulusCount++; ?>
                                @endif
                                @if($student->angkatan == $i && (!$student->skripsi || $student->skripsi->status_skripsi != 'lulus'))
                                <?php $belumLulusCount++; ?>
                                @endif
                                @endforeach
                                @if($sudahLulusCount == 0)
                                <td class="text-center">{{$sudahLulusCount}}</td>
                                @else
                                <td class="text-center"><a href="/dashboard/departemen/{{$user->ID_dep}}/recap/{{$i}}/skripsi/lulus/s">{{$sudahLulusCount}}</a></td>
                                @endif
                                @if($belumLulusCount == 0)
                                <td class="text-center">{{$belumLulusCount}}</td>
                                @else
                                <td class="text-center"><a href="/dashboard/departemen/{{$user->ID_dep}}/recap/{{$i}}/skripsi/belum/s">{{$belumLulusCount}}</a></td>
                                @endif
                                @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section 3 content -->
            <div class="section" id="section3">
                <div class="table-responsive">
                    <table class="table" id="status-table">
                        <thead>
                            <tr>
                                <th class="text-center" colspan="40" scope="col">Rekap Status Mahasiswa</th>
                            </tr>
                            <tr>
                                <th class="text-center" colspan="40" scope="col">Angkatan</th>
                            </tr>
                            <tr>
                                @for($i=2016;$i<=2023;$i++) <th class="text-center" colspan="5" scope="col">{{$i}}</th>
                                    @endfor
                            </tr>
                            <tr>
                                @for($i=0;$i<=7;$i++) <th class="text-center">Aktif</th>
                                    <th class="text-center">Cuti</th>
                                    <th class="text-center">Meninggal</th>
                                    <th class="text-center">Undur Diri</th>
                                    <th class="text-center">DO</th>
                                    @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @for($i=2016;$i<=2023;$i++) <?php
                                                        $aktifCount = 0;
                                                        $cutiCount = 0;
                                                        $meninggalCount = 0;
                                                        $undurDiriCount = 0;
                                                        $doCount = 0;
                                                        ?> @foreach($mahasiswa as $student) @if($student->angkatan == $i)
                                <?php
                                switch ($student->status) {
                                    case 'AKTIF':
                                        $aktifCount++;
                                        break;
                                    case 'CUTI':
                                        $cutiCount++;
                                        break;
                                    case 'MENINGGAL':
                                        $meninggalCount++;
                                        break;
                                    case 'UNDUR DIRI':
                                        $undurDiriCount++;
                                        break;
                                    case 'DO':
                                        $doCount++;
                                        break;
                                    default:
                                        break;
                                }
                                ?>
                                @endif
                                @endforeach
                                <td class="text-center">
                                    @if($aktifCount == 0)
                                    {{$aktifCount}}
                                    @else
                                    <a href="/dashboard/departemen/{{$user->ID_dep}}/recap/{{$i}}/status/aktif/i">{{$aktifCount}}</a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($cutiCount == 0)
                                    {{$cutiCount}}
                                    @else
                                    <a href="/dashboard/departemen/{{$user->ID_dep}}/recap/{{$i}}/status/cuti/i">{{$cutiCount}}</a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($meninggalCount == 0)
                                    {{$meninggalCount}}
                                    @else
                                    <a href="/dashboard/departemen/{{$user->ID_dep}}/recap/{{$i}}/status/meninggal/i">{{$meninggalCount}}</a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($undurDiriCount == 0)
                                    {{$undurDiriCount}}
                                    @else
                                    <a href="/dashboard/departemen/{{$user->ID_dep}}/recap/{{$i}}/status/undur-diri/i">{{$undurDiriCount}}</a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($doCount == 0)
                                    {{$doCount}}
                                    @else
                                    <a href="/dashboard/departemen/{{$user->ID_dep}}/recap/{{$i}}/status/do/i">{{$doCount}}</a>
                                    @endif
                                </td>
                                @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <hr />
            <div class="text-center">
                <button class="btn btn-light" data-toggle="modal" data-target="#printModal">Print</button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" style="max-width: 80%; max-height: 80vh;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="printModalLabel" style="color: black;">Print Table</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table" id="printTable" tabindex="-1">
                                <!-- Isi tabel di sini sesuai dengan kebutuhan Anda -->
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="printTable()">Print</button>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                /* Gaya untuk tabel di dalam modal */
                #printModal .modal-body table {
                    color: black;
                    background-color: white;
                    width: 100%;
                    max-width: 100%;
                    font-size: 12px;
                    border: 1px solid #dee2e6;
                    border-collapse: collapse;
                    max-height: 60vh;
                    overflow-y: auto;
                }

                #printModal .modal-body table th,
                #printModal .modal-body table td {
                    font-size: 8px;
                    padding: 4px;
                    text-align: center;
                    /* Horizontal centering */
                    vertical-align: middle;
                    /* Vertical centering */
                    border: 1px solid #dee2e6;
                    /* Add border to th and td */
                }

                #printModal .modal-body table a {
                    color: black;
                    text-decoration: none;
                    display: inline-block;
                    width: 100%;
                    padding: 4px;
                }
            </style>


            <script>
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

                    // Set the background color of the selected nav-pill with opacity
                    navPills.forEach((pill, i) => {
                        const backgroundColor = i === index ? 'rgba(76, 175, 80, 0.2)' : 'transparent'; // Green color with 0.2 opacity
                        const textColor = i === index ? '#fff' : ''; // Text color for better visibility
                        pill.style.backgroundColor = backgroundColor;
                        pill.style.color = textColor;
                    });

                    // Update modal content based on the active section
                    updateModalContent(index);
                }

                function updateModalContent(index) {
                    const modalBody = document.querySelector('#printModal .modal-body table');
                    const activeTable = sections[index].querySelector('.table');

                    // Clear previous content
                    modalBody.innerHTML = '';

                    // Append the active table to the modal body
                    modalBody.appendChild(activeTable.cloneNode(true));
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

                function printTable() {
                    window.print();
                }
            </script>

        </div>

    </div>
</div>

@endsection