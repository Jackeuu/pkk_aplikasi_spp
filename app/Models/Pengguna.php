<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;
    protected $table = 'tpengguna';
    protected $fillable = ['nama_pengguna', 'no_telp', 'email', 'hak_akses'];
}