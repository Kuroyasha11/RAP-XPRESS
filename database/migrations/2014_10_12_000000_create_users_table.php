<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_mitra')->default(false);
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('username')->unique()->nullable();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('no_hp')->unique();
            $table->string('ktp_sim')->unique();
            $table->string('image')->nullable();
            $table->foreignId('partner_id');
            $table->boolean('diterima')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
