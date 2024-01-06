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
                    Input Skripsi
                </div>
                <hr />
                <form action="/dashboard/mahasiswa/{{$user->NIM}}/academic/skripsi/edit" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="status_pkl">Status Skripsi</label>
                        <select class="form-control" id="status_pkl" name="status_skripsi" disabled>
                            <option value="{{$skripsi->status_skripsi}}">{{$skripsi->status_skripsi}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nilai_pkl">Nilai Skripsi</label>
                        <input type="text" class="form-control" id="nilai_skripsi" name="nilai_skripsi" value="{{$skripsi->nilai_skripsi}}" />
                    </div>
                    <div class="form-group">
                        <label for="file">Berkas Berita Acara Seminar skripsi</label>
                        <br>
                        <input type="file" name="file" id="file" class="dropzone" />
                        <p>Current File: {{$skripsi->berkas_skripsi}}</p>
                    </div>
                    <button type="submit" class="btn btn-light px-5" id="btn_tambah_skripsi">
                        <i class="zmdi zmdi-plus"></i>
                        Edit skripsi
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
</script>
@endsection