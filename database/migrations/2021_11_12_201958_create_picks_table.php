<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('picks2', function (Blueprint $table) {
            $table->id();
            $table->integer("ecapper_id")->nullable()->index();
            $table->string("title")->nullable();
            $table->text("teaser")->nullable();
            $table->text("body")->nullable();
            $table->dateTime("active_date")->nullable()->index();
            $table->dateTime("expiration_date")->nullable()->index();
            $table->dateTime("created_date")->nullable();
            $table->integer("price")->default(0)->index();
            $table->integer("price_id")->nullable();
            $table->string("sport")->nullable()->index();
            $table->string("type")->nullable();
            $table->boolean("is_released")->default(false);
            $table->boolean("is_featured")->default(false)->index();
            $table->string("outcome_wl")->nullable()->index();
            $table->integer("purchases")->default(0);
            $table->dateTime("wl_processed_date")->nullable()->index();
            $table->boolean("is_done")->default(false)->index();
            $table->tinyInteger("league_id")->nullable()->index();
            $table->integer("event_id")->nullable();
            $table->string("rating_type")->nullable()->index();
            $table->tinyInteger("rating_number")->nullable()->index();
            $table->string("pitcher")->nullable();
            $table->string("tplay_designation")->nullable();
            $table->string("tplay_title")->nullable();
            $table->string("selected_element")->nullable()->index();
            $table->string("element_value")->nullable();
            $table->integer("rot_id")->nullable();
            $table->string("side")->nullable();
            $table->string("team_name")->nullable();
            $table->dateTime("event_datetime")->nullable()->index();
            $table->integer("ticket_type")->nullable();
            $table->string("profit")->nullable();
            $table->string("juice")->nullable();
            $table->string("score")->nullable();
            $table->string("grade_executed_by")->nullable();
            $table->integer("modified_by")->nullable();
            $table->dateTime("modified_datetime")->nullable();
            $table->boolean("is_expired")->default(false);
            $table->string("group_key")->nullable();
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
        Schema::dropIfExists('picks2');
    }
}
