<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Operator;


class Users extends Model
{
    public $timestamps = false;
    protected $table = 'user';
    protected $primaryKey = 'user';
    protected $fillable = ['password', 'peran', 'user', 'NIM', 'NIP', 'ID_dep'];
    public $incrementing = false;

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class,'NIM', 'NIM');
    }

    public function dosen(){
        return $this->belongsTo(Dosen::class,'NIP', 'NIP');
    }

    public function operator(){
        return $this->belongsTo(Operator::class,'NIP', 'NIP');
    }

    public function departemen(){
        return $this->belongsTo(Departemen::class,'ID_dep', 'ID_departemen');
    }


    use HasFactory;
}
