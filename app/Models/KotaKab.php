<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Provinsi;

class KotaKab extends Model
{
    public $timestamps = false;
    protected $table = 'kota_kab';
    protected $primaryKey = 'kode_kota_kab';
    protected $fillable = ['kode_kota_kab', 'nama_kota_kab', 'kode_prov'];
    public $incrementing = false;

    public function provinsi(){
        return $this->belongsTo(Provinsi::class, 'kode_prov', 'kode_prov');
    }
    use HasFactory;
}
