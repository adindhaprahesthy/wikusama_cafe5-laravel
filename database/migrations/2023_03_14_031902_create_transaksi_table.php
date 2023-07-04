<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->bigIncrements('id_transaksi');
            $table->date('tgl_transaksi');
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('id_meja');
            $table->string('nama_pelanggan');
            $table->enum('status',['belum_bayar','lunas']);
            
            $table->foreign('id')->references('id')->on('users');
            $table->foreign('id_meja')->references('id_meja')->on('meja');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}