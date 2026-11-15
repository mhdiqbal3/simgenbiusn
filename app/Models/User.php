<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nim',
        'jurusan',
        'devisi',
        'photo',
        'ttd',
        'stempel',
        'jabatan',
        'request_reset',
        'otp',
        'otp_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Cek apakah user memiliki hak akses untuk membuka halaman sosialisasi
     */
    public function hasAksesSosialisasi(): bool
    {
        if (in_array($this->role, ['admin', 'sekretaris'])) {
            return true;
        }

        return SuratInternal::where(function ($query) {
                $query->where('jenis_surat', 'Surat Tugas Sosialisasi')
                      ->orWhere(function ($q) {
                          $q->where('jenis_surat', 'Surat Tugas')
                            ->where('kegiatan_st', 'LIKE', '%Sosialisasi%');
                      });
            })
            ->where(function ($q) {
                $name = trim($this->name);
                $q->where('anggota_st', $name)
                  ->orWhere('anggota_st', 'LIKE', '%' . $name . '%');
            })
            ->where(function ($q) {
                $q->where('jabatan_st', 'LIKE', '%Ketua Kelompok%')
                  ->orWhere('jabatan_st', 'LIKE', '%Sekretaris Kelompok%');
            })
            ->exists();
    }

    /**
     * Cek apakah user dapat mengelola (menambah, mengubah, menghapus) surat sosialisasi
     */
    public function canManageSosialisasi(): bool
    {
        return in_array($this->role, ['admin', 'sekretaris']);
    }

    /**
     * Cek apakah user memiliki hak akses penuh ke modul surat internal & eksternal
     */
    public function canAccessSurat(): bool
    {
        return in_array($this->role, ['admin', 'sekretaris']);
    }
}
