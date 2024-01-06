<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    public $timestamps = false;
    protected $table = 'operator';
    protected $primaryKey = 'NIP';
    protected $fillable = ['NIP', 'nama', 'alamat', 'no_HP', 'foto'];
    public $incrementing = false;
    use HasFactory;
}
