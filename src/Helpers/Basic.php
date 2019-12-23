<?php
use Illuminate\Support\Debug\Dumper;
if(!function_exists('path_'.\Codwelt\Blog\BlogServiceProvider::NAMESPACE_PROYECT)){
    /**
     * Devuleve la ruta completa de la ubicacion del paquete
     * @param string $path
     * @return string
     */
    function path_codwelt_blog($path = '')
    {
        return dirname(__DIR__) . ($path ? DIRECTORY_SEPARATOR.$path : $path);

    }
}

if(!function_exists('debugMe')){
    function debugMe(...$args)
    {
        foreach ($args as $x) {
            (new Dumper)->dump($x);
        }
    }
}

if(!function_exists('public_path_'.\Codwelt\Blog\BlogServiceProvider::NAMESPACE_PROYECT)){

    /**
     * Devuelve el path publico del storage luego de hace el storage:link
     * @param string $path
     * @return string
     */
    function public_path_codwelt_blog($path = ''){
        return storage_path('app/public/'.\Codwelt\Blog\BlogServiceProvider::NAMESPACE_PROYECT.($path ? DIRECTORY_SEPARATOR.$path : $path)) ;
    }
}

if(!function_exists('test_path_'.\Codwelt\Blog\BlogServiceProvider::NAMESPACE_PROYECT)){

    /**
     * Devuelve el path de la carpeta de los test
     * @param string $path
     * @return string
     */
    function test_path_codwelt_blog($path = '')
    {
        return dirname(path_codwelt_blog()) . DIRECTORY_SEPARATOR .'tests'.($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
