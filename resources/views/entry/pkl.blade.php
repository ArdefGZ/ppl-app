@extends('layout')
@section('content')
<div class="row mt-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <a href="/dashboard/mahasiswa/{{$user->NIM}}/academic">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    Edit PKL
                </div>
                <hr />
                <form action="/dashboard/mahasiswa/{{$user->NIM}}/academic/pkl/edit" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="status_pkl">Status PKL</label>
                        <select class="form-control" id="status_pkl" name="status_pkl" disabled>
                            <option value="">{{$pkl->status_pkl}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nilai_pkl">Nilai PKL</label>
                        <input type="text" class="form-control" id="nilai_pkl" name="nilai_pkl" value="{{$pkl->nilai_pkl}}" />
                    </div>
                    <div class="form-group">
                        <label for="file">Berkas Berita Acara Seminar PKL</label>
                        <br>
                        <input type="file" name="file" id="file" class="dropzone" />
                        <p>Current File: {{$pkl->berkas}}</p>
                    </div>
                    <button type="submit" class="btn btn-light px-5" id="btn_tambah_pkl">
                        <i class="zmdi zmdi-plus"></i>
                        Edit PKL
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    // Initialize Dropzone
    new Dropzone('#image-upload', {
        thumbnailWidth: 200,
        maxFilesize: 1,
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
        dictDefaultMessage: "Drop files here or click to upload",
    });

    // Tampilkan/sembunyikan input nilai PKL berdasarkan status
    const statusPKL = document.getElementById('status_pkl');
    const nilaiPKLInput = document.getElementById('nilai_pkl');
    statusPKL.addEventListener('change', function() {
        if (statusPKL.value === 'lulus') {
            nilaiPKLInput.style.display = 'block';
        } else {
            nilaiPKLInput.style.display = 'none';
        }
    });

    // Validasi jika status belum ambil
    const btnTambahPKL = document.getElementById('btn_tambah_pkl');
    btnTambahPKL.addEventListener('click', function() {
        if (statusPKL.value === 'belum_ambil') {
            alert('Anda harus mengambil PKL terlebih dahulu sebelum mengunggah berkas seminar PKL.');
        }
    });
</script>
@endsection