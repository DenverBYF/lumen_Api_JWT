<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Post extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('posts', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('uid');
			$table->string('title', 30);
			$table->longText('content');
			$table->integer('view');	//浏览量
			$table->integer('like');	//点赞数
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
        //
		Schema::drop('posts');
    }
}
