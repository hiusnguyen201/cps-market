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
            $table->string('email', 150)->unique();
            $table->string('password', 200)->nullable();
            $table->string('phone', 15);
            $table->string('address', 150)->nullable();
            $table->tinyInteger('status')->default(config("constants.user_status.Inactive"));
            $table->tinyInteger('gender')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->string("google_id", 100)->nullable();
            $table->string("facebook_id", 100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken(); // login token
            $table->foreign('role_id')->references('id')->on('roles');
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
