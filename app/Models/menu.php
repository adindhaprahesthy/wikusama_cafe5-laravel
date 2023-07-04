<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    protected $table = 'menu';
    protected $primarykey = 'id_menu';
    public $timestamps = false;

    protected $fillable = ['nama_menu', 'jenis', 'deskripsi', 'gambar', 'harga'];
    use HasFactory;
}
