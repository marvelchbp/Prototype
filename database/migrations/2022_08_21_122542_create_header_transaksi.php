<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('header_transaksi', function (Blueprint $table) {
            $table->integer('id_htrans')->autoIncrement();
            $table->integer('fk_id_pegawai');
            $table->integer('total_qty');
            $table->double('total_transaksi',8,2);
            $table->double('tunai_transaksi',8,2);
            $table->double('kembali_transaksi',8,2);
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('header_transaksi');
    }
};
