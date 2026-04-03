<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswas';
    protected $primaryKey = 'nis';
    public $incrementing = false;
    protected $fillable = ['nis', 'kelas'];
}
