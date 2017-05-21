<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagnoseHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnose_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->text('symptoms');
            $table->float('per_cent');
            $table->string('message');
            $table->text('advice');
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
        Schema::dropIfExists("diagnose_histories");
    }
}
