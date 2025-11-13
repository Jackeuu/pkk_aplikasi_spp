<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UangDaftarUlang extends Model
{
    use HasFactory;

    protected $table = 'tuangdaftarulang';

    protected $primaryKey = "idudu";

    protected $fillable = ['idudu', 'nominal_du', 'tahun_ajaran'];
}
