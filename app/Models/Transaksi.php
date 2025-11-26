<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'kode_transaksi',
        'kasir_id',
        'total_harga',
        'bayar',
        'kembalian',
        'status',
        'status_koki',
    ];


    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }
}

