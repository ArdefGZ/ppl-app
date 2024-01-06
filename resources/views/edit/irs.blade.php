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
                    Edit IRS
                </div>
                <hr />
                <form action="/dashboard/mahasiswa/{{$user->NIM}}/academic/irs/{{$irs->id_irs}}/confirm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="smst_aktif">Semester</label>
                        <input type="text" class="form-control" id="smst_aktif" name="smst_aktif" value="{{$irs->smst_aktif}}" disabled/>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_sks">Jumlah SKS Diambil</label>
                        <input type="text" class="form-control" id="jumlah_sks" name="jumlah_sks" value="{{$irs->jumlah_sks}}" />
                    </div>
                    <div class="form-group">
                        <label for="file">Berkas IRS</label>
                        <br>
                        <input type="file" name="file" id="file" class="dropzone" />
                        <!-- Display the current file name -->
                        <p>Current File: {{$irs->berkas_irs}}</p>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-light px-5">
                            <i class="zmdi zmdi-plus"></i>
                            Edit IRS
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    // Initialize Dropzone
    new Dropzone('#file', {
        thumbnailWidth: 200,
        maxFilesize: 1,
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
        dictDefaultMessage: "Drop files here or click to upload",
    });
</script>
@endsection
