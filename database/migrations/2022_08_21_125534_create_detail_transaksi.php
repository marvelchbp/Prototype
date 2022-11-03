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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_id_htrans');
            $table->string('fk_kode_barang',30);
            $table->integer('qty');
            $table->string('nama_barang',150);
            $table->string('satuan',7);
            $table->double('harga_barang',8,2);
            $table->integer('discount')->nullable($value = true);
            $table->double('total',9,2);
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
        Schema::dropIfExists('detail_transaksi');
    }
};
