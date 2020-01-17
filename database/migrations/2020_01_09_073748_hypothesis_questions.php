<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HypothesisQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hypothesis_question', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('hypothesis_id')->index();
            $table->bigInteger('question_id')->index();
            $table->double('plus');
            $table->double('minus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hypothesis_question');
    }
}
