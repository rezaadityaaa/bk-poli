<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class poli extends Model
{
    protected $fillable = [
        'nama_poli',
        'deskripsi',
    ];
    protected $table = 'polis'; // Tambahkan baris ini untuk menentukan nama tabel jika berbeda
    public function users()
    {
        return $this->hasMany(User::class, 'id_poli');
    }
}
