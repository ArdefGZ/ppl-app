<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mahasiswa;
use App\Models\Status;

class KHS extends Model
{
    public $timestamps = false;
    protected $table = 'khs';
    protected $primaryKey = 'id_khs';
    protected $fillable = ['id_khs', 'smt_aktif', 'SKS_semester', 'SKS_kumulatif','IP_smt', 'IP_Kumulatif', 'berkas_KHS', 'NIM', 'status'];
    public $incrementing = false;

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'NIM', 'NIM');
    }

    public function toStatus(){
        return $this->belongsTo(Status::class, 'status', 'id');
    }
    use HasFactory;
}
