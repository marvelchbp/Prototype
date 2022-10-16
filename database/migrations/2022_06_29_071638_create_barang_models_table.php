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
        Schema::create('barang_models', function (Blueprint $table) {
            $table->string('kode_barang',30)->primary();
            $table->string('nama_barang',150);
            $table->double('harga_grosir',8,2);
            $table->double('harga_eceran',8,2);
            $table->string('satuan',7);
            $table->integer('faktor');
            $table->integer('stock');
            $table->string('deskripsi',255)->nullable($value = true);
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
        Schema::dropIfExists('barang_models');
    }
};
