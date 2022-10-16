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
        Schema::create('member_models', function (Blueprint $table) {
            $table->integer('kode_member')->autoIncrement();
            $table->string('nama_member',255);
            $table->string('alamat',255)->nullable($value = true);
            $table->string('nomor_telepon_member',15)->nullable($value = true);
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
        Schema::dropIfExists('member_models');
    }
};
