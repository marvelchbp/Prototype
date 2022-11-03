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
        Schema::create('stock_log_history', function (Blueprint $table) {
            $table->id();
            $table->string('fk_kode_barang',30);
            $table->integer('fk_id_pegawai');
            $table->integer('stock_sebelum');
            $table->integer('stock_sesudah');
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_log_history');
    }
};
