<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PKL;
use App\Models\Skripsi;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\KotaKab;
use App\Models\Dosen;

class Mahasiswa extends Model
{
    public $timestamps = false;
    protected $table = 'mahasiswa';
    protected $primaryKey = 'NIM';
    protected $fillable = ['NIM', 'nama', 'email', 'alamat', 'no_HP', 'angkatan', 'status', 'jalur_masuk', 'foto', 'kode_kota_kab', 'NIP'];
    public $incrementing = false;

    public function pkl(){
        return $this->belongsTo(PKL::class,'NIM', 'NIM');
    }

    public function skripsi(){
        return $this->belongsTo(Skripsi::class,'NIM', 'NIM');
    }

    public function irs(){
        return $this->belongsTo(IRS::class,'NIM', 'NIM');
    }

    public function khs(){
        return $this->belongsTo(KHS::class,'NIM', 'NIM');
    }

    public function kotakab(){
        return $this->belongsTo(KotaKab::class, 'kode_kota_kab', 'kode_kota_kab');
    }

    public function doswal(){
        return $this->belongsTo(Dosen::class,'NIP','NIP');
    }
    use HasFactory;
}
