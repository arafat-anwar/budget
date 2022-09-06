<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Plans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sector_id', false);
            $table->foreign('sector_id')->references('id')->on('sectors')->restrictOnDelete()->cascadeOnUpdate();

            $table->date('date');
            $table->time('time');
            $table->string('title');
            $table->text('description')->nullable();
            $table->double('min_amount')->default(0);
            $table->double('max_amount')->default(0);
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
        Schema::dropIfExists('plans');
    }
}
