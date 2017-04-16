<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('address')->nullable();
            $table->float('weight')->nullable()->default(0);
            $table->float('unit_price')->nullable()->default(0);
            $table->datetime('pickup_at')->nullable();
            $table->datetime('picked_at')->nullable();
            $table->datetime('delivered_at')->nullable();
            $table->datetime('cleaned_at')->nullable();
            $table->string('status')->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('orders');
    }
}
