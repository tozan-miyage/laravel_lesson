<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCloumnsToUsers extends Migration
{
    /**
     * Run the migrations.追加すること
     *
     * @return void
     */
     //データベースに追加する
    public function up()
    {
        //usersというテーブルにcloumと型を指定
        Schema::table('users', function (Blueprint $table) {
            //string型で郵便番号を入れる。初期値は'空'
            $table->string('postal_code')->default('');
            //text型で住所を入れる
            $table->text('address')->default('');
            //電話番号を入れる
            $table->string('phone')->default('');
        });
    }

    /**
     * Reverse the migrations.元に戻すこと
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
