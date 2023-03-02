<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('user_id')->index();
            $table->string('username',45)->unique();
            $table->string('email')->unique();
            $table->bigInteger('permission_type_id')->unsigned();
            // $table->bigInteger('profile_id')->unsigned();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            
            // $table->foreign('profile_id')->references('id')->on('user_profile');
            $table->foreign('permission_type_id')->references('permission_type_id')->on('permission_type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
