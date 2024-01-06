<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    public $timestamps = false;
    protected $table = 'dosen';
    protected $primaryKey = 'NIP';
    protected $fillable = ['NIP', 'nama', 'email', 'alamat', 'no_HP', 'foto'];
    public $incrementing = false;
    use HasFactory;
}
