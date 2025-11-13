<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TransaksiSpp extends Model
{
    use HasFactory;

    protected $table = 'ttransaksi';
    protected $fillable = ['nis', 'tanggalBayar', 'idp', 'bulan', 'tahunBayar'];

    public function petugas()
    {
        return $this->belongsTo(User::class, 'idp', 'idp');
    }



}
