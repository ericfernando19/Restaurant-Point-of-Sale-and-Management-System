<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    protected $fillable = [
        'transaksi_id',
        'menu_id',
        'qty',
        'subtotal'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}

