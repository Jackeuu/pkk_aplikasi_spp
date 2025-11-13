<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'nis'; // <--- tambahkan baris ini
    public $incrementing = false;  // <--- tambahkan kalau NIS bukan auto increment
    protected $keyType = 'string'; // <--- tambahkan kalau NIS berupa teks, bukan angka
    protected $fillable = ['nama_siswa', 'kelas', 'jenis_kelamin', 'alamat', 'idspp'];
}
