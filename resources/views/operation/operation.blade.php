@extends('layout')
@section('content')
<div class="col-lg-13">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <a href="/dashboard/operator/{{$user->NIP}}">
                    <i class="fas fa-chevron-left"></i>
                </a>
                Data Mahasiswa
            </div>
            <ul class="nav-pill">
                <li><a href="#section1">Mahasiswa</a></li>
                <li><a href="#section2">Dosen</a></li>
            </ul>
            <hr />
            <div class="section" id="section1">
                <a href="/dashboard/operator/{{$user->NIP}}/manajemen/addaccount" type="button" class="btn btn-light btn-round px-5 d-flex justify-content-center align-items-center">
                    <i class="fas fa-folder-plus"></i> &nbsp; Tambah Akun
                </a>
                <br>
                <div class="col-lg-12">
                    <form action="#" method="GET" class="search-bar" id="search-form">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="keywords" id="search-input" class="form-control" placeholder="Enter keywords">
                            <div class="input-group-append">
                                <button class="btn btn-light" type="button" id="search-button">
                                    <i class="icon-magnifier"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table" id="student-table">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Angkatan</th>
                                <th scope="col">Dosen Wali</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $counter = 1; @endphp
                            @foreach($mahasiswa as $student)
                            <tr>
                                <th scope="row">{{$counter++}}</th>
                                <td>{{$student->nama}}</td>
                                <td>{{$student->NIM}}</td>
                                <td>{{$student->angkatan}}</td>
                                <td>{{$student->doswal->nama}}</td>
                                <td>
                                    <a href="/dashboard/operator/{{$user->NIP}}/manajemen/{{$student->NIM}}" type="button" class="btn btn-light btn-round px-5 d-flex justify-content-center align-items-center">
                                        <i class="fas fa-folder-open"></i> &nbsp; Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Section 2 content -->
            <div class="section" id="section2">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama</th>
                                <th scope="col">NIP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $counter = 1; @endphp
                            @foreach($dosen as $lecture)
                            <tr>
                                <th scope="row">{{$counter++}}</th>
                                <td>{{$lecture->nama}}</td>
                                <td>{{$lecture->NIP}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <script>
    document.addEventListener('DOMContentLoaded', function () {
        const navPills = document.querySelectorAll('.nav-pill a');
        const sections = document.querySelectorAll('.section');
        const searchForm = document.getElementById('search-form');
        const studentTable = document.getElementById('student-table');
        const allStudents = {!! json_encode($mahasiswa) !!};
        const allDosen = {!! json_encode($dosen) !!};

        if (searchForm && studentTable) {
            searchForm.addEventListener('submit', function (event) {
                event.preventDefault();

                const keywords = document.getElementById('search-input').value.toLowerCase();

                // Perform client-side search
                const studentResults = allStudents.filter(student =>
                    student.nama.toLowerCase().includes(keywords) ||
                    student.NIM.toLowerCase().includes(keywords)
                );

                const dosenResults = allDosen.filter(dosen =>
                    dosen.nama.toLowerCase().includes(keywords) ||
                    dosen.NIP.toLowerCase().includes(keywords)
                );

                // Check which section is currently active
                const activeSection = Array.from(sections).findIndex(section => section.style.display === 'block');

                // Update the table with the new search results based on the active section
                if (activeSection === 0) {
                    updateTable(studentResults, true);
                } else if (activeSection === 1) {
                    updateTable(dosenResults, false);
                }
            });

            // Added event listener for the search button
            const searchButton = document.getElementById('search-button');
            if (searchButton) {
                searchButton.addEventListener('click', function () {
                    searchForm.dispatchEvent(new Event('submit'));
                });
            }

            // Added event listener for pressing Enter key in the search input
            const searchInput = document.getElementById('search-input');
            if (searchInput) {
                searchInput.addEventListener('keypress', function (event) {
                    if (event.key === 'Enter') {
                        searchForm.dispatchEvent(new Event('submit'));
                    }
                });
            }
        }

        function updateTable(results, isStudent) {
            // Clear existing table rows
            const tbody = document.querySelector('#student-table tbody');
            if (tbody) {
                tbody.innerHTML = '';
                let counter = 1;


                // Insert new rows based on the search results
                results.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${counter++}</td>
                        <td>${item.nama}</td>
                        <td>${isStudent ? item.NIM : item.NIP}</td>
                        <td>${isStudent ? item.angkatan : ''}</td>
                        <td>${isStudent ? item.doswal.nama : ''}</td>
                        <td>
                            <a href="/dashboard/operator/{{$user->NIP}}/manajemen/${isStudent ? item.NIM : item.NIP}" type="button" class="btn btn-light btn-round px-5 d-flex justify-content-center align-items-center">
                                <i class="fas fa-folder-open"></i> &nbsp; Detail
                            </a>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }
        }

        // Event listener for nav-pills to switch sections
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

        function showSection(index) {
            // Hide all sections
            sections.forEach((section) => {
                section.style.display = 'none';
            });
            // Show the selected section
            sections[index].style.display = 'block';
        }
    });
</script>
        </div>
    </div>
</div>
@endsection
