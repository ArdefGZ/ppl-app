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
                    Edit KHS
                </div>
                <hr />
                <form action="/dashboard/mahasiswa/{{$user->NIM}}/academic/addPKL/confirm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="smst_aktif">Semester</label>
                        <input type="text" class="form-control" id="smt_aktif" name="smt_aktif" value="{{$khs->smt_aktif}}" disabled />
                    </div>
                    <div class="form-group">
                        <label for="jumlah_sks">Jumlah SKS Diambil</label>
                        <input type="text" class="form-control" id="jumlah_sks" name="jumlah_sks" value="{{$khs->SKS_semester}}" />
                    </div>
                    <div class="form-group">
                        <label for="ips">IP Semester</label>
                        <input type="text" class="form-control" id="ips" name="ips" value="{{$khs->IP_smt}}" />
                    </div>
                    <button type="submit" class="btn btn-light px-5" id="btn_tambah_pkl">
                        <i class="zmdi zmdi-edit"></i>
                        Edit KHS
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