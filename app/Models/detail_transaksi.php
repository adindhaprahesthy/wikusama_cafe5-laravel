<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_transaksi extends Model
{
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detail_transaksi';
    public $timestamps = false;

    protected $fillable = ['id_transaksi', 'id_menu', 'harga', 'qty', 'subtotal'];

    public function users(){
        return $this->belongsTo('App\transaksi', 'id_transaksi', 'id_transaksi'); 
        return $this->belongsTo('App\menu', 'id_menu', 'id_menu'); 
    }
    use HasFactory;
}
