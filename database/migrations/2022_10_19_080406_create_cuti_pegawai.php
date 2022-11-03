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
        Schema::create('cuti_pegawai', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_emailPegawai');
            $table->date('tanggalAwalCuti');
            $table->date('tanggalAkhirCuti');
            $table->integer('jumlahCuti');
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
        Schema::dropIfExists('cuti_pegawai');
    }
};
