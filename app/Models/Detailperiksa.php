<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Detailperiksa extends Model
{
    use HasFactory;

    protected $table = 'detail_periksas'; // Tambahkan baris ini

    protected $fillable = [
        'id_periksa',
        'id_obat',
    ];


    public function periksa() : BelongsTo
    {
        return $this->belongsTo(Periksa::class, 'id_periksa');
    }
    public function obat() : BelongsTo
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }
}
