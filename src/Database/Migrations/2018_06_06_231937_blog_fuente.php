<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
 * Class Fuente
 * @package CodWelt\Blog\migrations
 * @author FuriosoJack <iam@furiosojack.com>
 */
class BlogFuente extends Migration
{

    private $tablename = "blog_fuentes";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->string('autor');
            $table->date('fecha_consulta');
            $table->string('ano_publicacion',4)->nullable();
            $table->string('url')->nullable();
            $table->string("titulo");
            $table->unsignedInteger('post_id');
            $table->foreign('post_id','blog_post_fuentes_fk')->references('id')->on('blog_posts');
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
        Schema::dropIfExists($this->tablename);
    }

}