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
                    Input KHS
                </div>
                <hr />
                <form action="/dashboard/mahasiswa/{{$user->NIM}}/academic/addKHS/confirm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="smst_aktif">Semester</label>
                        @php
                        if($user->mahasiswa->khs == null){
                        $smt_terakhir = 0;
                        }
                        else{
                            $smt_terakhir = \App\Models\KHS::where('NIM', $user->NIM)->orderBy('smt_aktif', 'desc')->first()->smt_aktif;
                        }
                        @endphp
                        <select class="form-control" id="smst_aktif" name="smst_aktif">
                            @for($i = $smt_terakhir+1; $i <= 14; $i++) <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_sks">Jumlah SKS Diambil</label>
                        <input type="text" class="form-control" id="jumlah_sks" name="jumlah_sks" placeholder="Masukkan Jumlah SKS" />
                    </div>
                    <div class="form-group">
                        <label for="ips">IP Semester</label>
                        <input type="text" class="form-control" id="ips" name="ips" placeholder="Masukkan IP Semester" />
                    </div>
                    <div class="form-group">
                        <label for="file">Berkas KHS</label>
                        <br>
                        <input type="file" name="file" id="file" class="dropzone" />
                    </div>
                    <button type="submit" class="btn btn-light px-5" id="btn_tambah_pkl">
                        <i class="zmdi zmdi-plus"></i>
                        Tambah KHS
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