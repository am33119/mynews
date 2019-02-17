<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    //関数upには、マイグレーション実行時のコード
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title'); // ニュースのタイトルを保存するカラム
            $table->string('body');  // ニュースの本文を保存するカラム
            $table->string('image_path')->nullable();  // 画像のパスを保存するカラム(->nullable()という記述は、画像のパスは空でも保存できます、という意味)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    //関数downには、マイグレーションの取り消しを行う為のコード
    public function down()
    {
        //もしnewsというテーブルが存在すれば削除する
        Schema::dropIfExists('news');
    }
}
