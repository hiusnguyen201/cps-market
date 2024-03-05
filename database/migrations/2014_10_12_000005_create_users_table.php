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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 200);
            $table->string('avatar', 200)->nullable();
            $table->string('phone', 15);
            $table->string('address', 150)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('gender');
            $table->integer('role_id');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken(); // login token
            $table->timestamps();
            $table->timestamp("deleted_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};