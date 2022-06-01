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
        Schema::create('subcampos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campo_id');
            $table->unsignedBigInteger('subcampo_id');
            $table->integer('orden')->default(1);
            $table->timestamps();
            $table->unique(['campo_id', 'subcampo_id']);
            $table->foreign('campo_id')->references('id')->on('campos')->onDelete('cascade');
            $table->foreign('subcampo_id')->references('id')->on('campos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcampos');
    }
};
