<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $fillable = ['nama_depan', 'jenis_kelamin', 'agama', 'alamat', 'avatar', 'user_id'];

    public function getavatar()
    {
        if (!$this->avatar) {
            return asset('images/bintang laut.png');
        }
        return asset('storage/' . $this->avatar);
    }

    public function mapel()
    {
        return $this->belongsToMany(Mapel::class)->withPivot('nilai')->withTimestamps();
    }

    // Fungsi untuk dashboard
    public static function jumlahSiswa()
    {
        return self::count();
    }

    public static function siswaPerKelas()
    {
        return self::selectRaw('kelas, COUNT(*) as jumlah')
            ->groupBy('kelas')
            ->get();
    }

    public static function jumlahLaki()
    {
        return self::where('jenis_kelamin', 'L')->count();
    }

    public static function jumlahPerempuan()
    {
        return self::where('jenis_kelamin', 'P')->count();
    }

    public static function siswaTerbaru()
    {
        return self::latest()->take(5)->get();
    }
}
