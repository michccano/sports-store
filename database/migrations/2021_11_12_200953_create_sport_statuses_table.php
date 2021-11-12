<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSportStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_status', function (Blueprint $table) {
            $table->id();
            $table->integer("sport_id");
            $table->integer("league_id");
            $table->boolean("status")->default(true);
            $table->string("sport_name")->nullable();
            $table->string("sport_abbreviation")->nullable();
            $table->string("league_name")->nullable();
            $table->string("league_abbreviation")->nullable();
            $table->string("sport_image")->nullable();
            $table->integer("modified_by")->nullable();
            $table->integer("playoffs_series")->default(0);
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
        Schema::dropIfExists('sport_status');
    }
}
