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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("code", 15)->unique();
            $table->string('name', 150)->unique();
            $table->string('slug', 250)->unique();
            $table->integer('price')->default(0);
            $table->integer('sale_price')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('sold')->default(0);
            $table->string('description', 3000)->nullable();
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};