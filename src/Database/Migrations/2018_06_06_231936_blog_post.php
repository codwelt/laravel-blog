<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class Post
 * @package CodWelt\Blog\migrations
 * @author FuriosoJack <iam@furiosojack.com>
 */
class BlogPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->longText('contenido');
            $table->string('patch_miniatura');
            $table->longText("resumen");
            $table->string('user_id')->index();
            $table->string('slug')->unique();
            $table->text('meta_keywords')->nullable();
            $table->string('state')->default(\Codwelt\Blog\Operations\Models\StatePost::DRAFT);
            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('blog_post_hashtags', function (Blueprint $table) {
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('hashtag_id');
            $table->foreign('post_id','blog_post_hashtag_fk')->references('id')->on('blog_posts');
            $table->foreign('hashtag_id','blog_hashtag_post_fk')->references('id')->on('blog_hashtags');
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
        Schema::dropIfExists('blog_post_hashtags');
        Schema::dropIfExists('blog_posts');
    }

}