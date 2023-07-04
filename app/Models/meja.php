<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class meja extends Model
{
    protected $table = 'meja';
    protected $primarykey = 'id_meja';
    public $timestamps = false;

    protected $fillable = ['nomor_meja', 'status'];
    use HasFactory;
}
