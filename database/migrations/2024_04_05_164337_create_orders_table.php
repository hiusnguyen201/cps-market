<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("code", 15);
            $table->integer("quantity");
            $table->integer("sub_total");
            $table->integer("shipping_fee");
            $table->integer("total");
            $table->tinyInteger("payment_method");
            $table->tinyInteger("payment_status");
            $table->timestamp("paid_date")->nullable();
            $table->tinyInteger("status");
            $table->unsignedBigInteger("customer_id");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('customer_id')->references('id')->on('users');
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
};