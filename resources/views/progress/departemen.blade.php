@extends('layout')
@section('content')

<div class="col-lg-13">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <a href="/dashboard/dosen/{{$user->NIP}}">
                    <i class="fas fa-chevron-left"></i>
                </a>
                Progress Mahasiswa
            </div>
            <hr />
            <div class="col-lg-12">
                <form action="#" method="GET" class="search-bar" id="search-form">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="keywords" id="search-input" class="form-control" placeholder="Enter keywords">
                        <div class="input-group-append">
                            <button class="btn btn-light" type="submit">
                                <i class="icon-magnifier"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <br />
            <div class="section" id="section1">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama</th>
                                <th scope="col">NIM</th>
                                <th scope="col">View</th>
                            </tr>
                        </thead>
                        <tbody id="student-table">
                            @php $counter = 1; @endphp
                            @foreach($mahasiswa as $student)
                            <tr>
                                <td>{{$counter++}}</td>
                                <td>{{$student->nama}}</td>
                                <td>{{$student->NIM}}</td>
                                <td>
                                    <a href="/dashboard/dosen/{{$user->NIP}}/progress/{{$student->NIM}}">
                                        <button type="button" class="btn btn-light px-3">
                                            View
                                        </button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.getElementById('search-form');
        const studentTable = document.getElementById('student-table');
        const allStudents = {
            !!json_encode($mahasiswa) !!
        }; // Convert PHP array to JavaScript array

        if (searchForm && studentTable) {
            searchForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const keywords = document.getElementById('search-input').value.toLowerCase();

                // Perform client-side search
                const results = allStudents.filter(student =>
                    (student.nama.toLowerCase().includes(keywords) ||
                        student.NIM.toLowerCase().includes(keywords))
                );

                // Update the table with the new search results
                updateTable(results);
            });
        }

        function updateTable(results) {
            // Clear existing table rows
            if (studentTable) {
                studentTable.innerHTML = '';

                // Insert new rows based on the search results
                results.forEach(student => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${student.nama}</td>
                        <td>${student.NIM}</td>
                        <td>
                            <a href="/dashboard/departemen/progress/${student.NIM}">
                                <button type="button" class="btn btn-light px-3">
                                    View
                                </button>
                            </a>
                        </td>
                    `;
                    if (studentTable) {
                        studentTable.appendChild(row);
                    }
                });
            }
        }
    });
</script>
@endsection