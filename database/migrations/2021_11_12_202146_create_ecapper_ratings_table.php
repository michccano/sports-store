<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcapperRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecapper_rating', function (Blueprint $table) {
            $table->id();
            $table->integer('ecapper_id')->nullable();
            $table->string('free')->nullable();
            $table->string('lean')->nullable();
            $table->string('reg')->nullable();
            $table->string('strong')->nullable();
            $table->string('topplay')->nullable();

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
        Schema::dropIfExists('ecapper_rating');
    }
}
