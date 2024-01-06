<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    public $timestamps = false;
    protected $table = 'provinsi';
    protected $primaryKey = 'kode_prov';
    protected $fillable = ['kode_prov', 'nama_prov'];
    public $incrementing = false;

    public function kotaKab(){
        return $this->belongsTo(KotaKab::class,'kode_prov', 'kode_prov');
    }
    use HasFactory;
}
