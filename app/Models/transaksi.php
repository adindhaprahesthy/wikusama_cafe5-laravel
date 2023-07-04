<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false;

    protected $fillable = ['id_transaksi', 'tgl_transaksi', 'id', 'id_meja', 'nama_pelanggan', 'status'];

            public function users(){
                return $this->belongsTo('App\User', 'id', 'id'); 
           }

            public function meja(){
                return $this->belongsTo('App\meja', 'id_meja', 'id_meja'); 
            }
    use HasFactory;
}
