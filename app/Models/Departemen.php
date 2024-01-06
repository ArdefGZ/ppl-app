<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    public $timestamps = false;
    protected $table = 'departemen';
    protected $primaryKey = 'ID_departemen';
    protected $fillable = ['Nama_departemen', 'ID_departemen', 'ThnBerdiri', 'Akreditasi'];
    public $incrementing = false;
    use HasFactory;
}
