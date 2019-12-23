<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
 * Class Fuente
 * @package CodWelt\Blog\migrations
 * @author FuriosoJack <iam@furiosojack.com>
 */
class TableImagen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('path')->nullable();
            $table->string('full_path');
            $table->string('extension');
            $table->string('realname');
            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('blog_posts');
            $table->timestamps();
        });

    }

    /**s
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_files');
    }

}