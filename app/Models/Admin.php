<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    // Nama tabel di database
    protected $table = 'admins';

    // Kolom yang boleh diisi
    protected $fillable = [
        'username',
        'password',
    ];

    // Sembunyikan password saat data dipanggil
    protected $hidden = [
        'password',
    ];
}