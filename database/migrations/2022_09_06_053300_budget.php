<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Budget extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sector_id', false);
            $table->foreign('sector_id')->references('id')->on('sectors')->restrictOnDelete()->cascadeOnUpdate();

            $table->integer('year');
            $table->string('month');
            $table->double('budget')->default(0);
            $table->double('remarks')->nullable();
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
        Schema::dropIfExists('budget');
    }
}
