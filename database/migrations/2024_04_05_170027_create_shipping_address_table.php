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
        Schema::create('shipping_address', function (Blueprint $table) {
            $table->id();
            $table->string("customer_name", 100);
            $table->string("customer_email", 150);
            $table->string("customer_phone", 15);
            $table->integer("province");
            $table->integer("district");
            $table->integer("ward")->nullable();
            $table->string("address", 100);
            $table->string("note", 100)->nullable();
            $table->unsignedBigInteger("order_id");
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_address');
    }
};
