<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
 * Class Fuente
 * @package CodWelt\Blog\migrations
 * @author FuriosoJack <iam@furiosojack.com>
 */
class TableComentarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_commentators', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('model_id')->nullable();
            $table->timestamps();
        });

        Schema::create('blog_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content');
            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('blog_posts');
            $table->integer('commentator_id')->unsigned();
            $table->foreign('commentator_id')->references('id')->on('blog_commentators');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**s
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_comments');
        Schema::dropIfExists('blog_commentators');
    }

}