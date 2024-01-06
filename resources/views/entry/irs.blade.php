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
                    Input IRS
                </div>
                <hr />
                <form action="/dashboard/mahasiswa/{{$user->NIM}}/academic/addIRS/confirm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="smst_aktif">Semester</label>
                        @php
                        if($user->mahasiswa->irs == null){
                        $smt_terakhir = 0;
                        }
                        else{
                        $smt_terakhir = \App\Models\IRS::where('NIM', $user->NIM)->orderBy('smst_aktif', 'desc')->first()->smst_aktif;
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
                        <label for="file">Berkas IRS</label>
                        <br>
                        <input type="file" name="file" id="file" class="dropzone" />
                    </div>
                    @php
                    $sks_total = 0;
                    foreach($khs as $k){
                    if($k->NIM == $user->NIM){
                    $sks_total += $k->SKS_semester;
                    }
                    }
                    @endphp
                    @if($sks_total >= 100 && $user->mahasiswa->pkl->status_pkl == 'belum ambil')
                    <div class="form-group">
                        <label for="confirm">Apakah ingin mengambil PKL?</label>
                        <!-- Checkbox -->
                        <input type="checkbox" name="confirm" id="confirm" value="1" data-target="pklFields" />
                    </div>
                    <div id="pklFields" style="display: none;">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="text" class="form-control" value="{{$user->mahasiswa->pkl->status_pkl}}" name="status">
                        </div>
                        <div class="form-group">
                            <label for="nilai_pkl">Nilai</label>
                            <input type="text" class="form-control" id="nilai_pkl" name="nilai_pkl">
                        </div>
                        <div class="form-group">
                            <label for="file-pkl">Berkas Berita Acara Seminar PKL</label>
                            <br>
                            <input type="file" name="file-pkl" id="file-pkl" class="dropzone" />
                        </div>
                    </div>
                    @endif
                    @if($sks_total >= 138 && $user->mahasiswa->skripsi->status_skripsi == 'belum ambil')
                    <div class="form-group">
                        <label for="confirmSkripsi">Apakah ingin mengambil Skripsi?</label>
                        <!-- Checkbox -->
                        <input type="checkbox" name="confirmSkripsi" id="confirmSkripsi" value="1" data-target="skripsiFields" />
                    </div>
                    <div id="skripsiFields" style="display: none;">
                        <div class="form-group">
                            <label for="statusSkripsi">Status</label>
                            <input type="text" class="form-control" value="{{$user->mahasiswa->skripsi->status_skripsi}}" name="statusSkripsi">
                        </div>
                        <div class="form-group">
                            <label for="nilai_skripsi">Nilai</label>
                            <input type="text" class="form-control" id="nilai_skrpsi" name="nilai_skripsi">
                        </div>
                        <div class="form-group">
                            <label for="file-skripsi">Berkas Berita Acara Seminar Skripsi</label>
                            <br>
                            <input type="file" name="file-skripsi" id="file-skripsi" class="dropzone" />
                        </div>
                    </div>
                    @endif
                    <div class="form-group">
                        <button type="submit" class="btn btn-light px-5">
                            <i class="zmdi zmdi-plus"></i>
                            Tambah IRS
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
    document.addEventListener('DOMContentLoaded', function() {
        var checkboxes = document.querySelectorAll('input[type="checkbox"][data-target]');

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var targetId = this.getAttribute('data-target');
                var targetElement = document.getElementById(targetId);
                if (targetElement) {
                    targetElement.style.display = this.checked ? 'block' : 'none';
                }
            });
        });

        new Dropzone('#image-upload', {
            thumbnailWidth: 200,
            maxFilesize: 1,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
            dictDefaultMessage: "Drop files here or click to upload",
        });
    });
</script>
@endsection