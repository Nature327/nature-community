<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discussions', function (Blueprint $table) {
            //帖子id
            $table->increments('id');
            //帖子标题
            $table->string('title');
            //帖子内容
            $table->text('body');
            //user表的外键
            $table->integer('user_id')->unsigned();
            //该帖子最后由谁更新
            $table->integer('last_user_id')->unsigned();
            //设置外键关联
            $table->foreign('user_id')
                            ->references('id')
                            ->on('users')
                            ->onDelete('cascade');
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
        Schema::drop('discussions');
    }
}
