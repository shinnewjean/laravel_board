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
            $table->string('email')->unique();
            $table->string('password',60); // 암호화의 최대 길이수=60
            $table->string('name'); // 225문자
            // $table->timestamp('email_verified_at')->nullable(); // email인증
            // $table->rememberToken(); // 로그인 유지하기 기능
            $table->timestamps(); // create,update date 자동생성
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
        Schema::dropIfExists('users');
    }
};
