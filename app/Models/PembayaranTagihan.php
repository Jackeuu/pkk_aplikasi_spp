<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\returnArgument;

class PembayaranTagihan extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_tagihan';

    protected $fillable = ['nis', 'tanggal_bayar', 'jumlah_tagihan', 'bayar', 'sisa', 'kembalian', 'no_kuitansi', 'status', 'keterangan'];


    
}
