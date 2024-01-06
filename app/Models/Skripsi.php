<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skripsi extends Model
{
    public $timestamps = false;
    protected $table = 'skripsi';
    protected $primaryKey = 'NIM';
    protected $fillable = ['NIM', 'nilai_skripsi', 'berkas_skripsi'];
    public $incrementing = false;
    use HasFactory;

    function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class, 'NIM', 'NIM');
    }
}
