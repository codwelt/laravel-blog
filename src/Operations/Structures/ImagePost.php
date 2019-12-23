<?php


namespace Codwelt\Blog\Operations\Structures;


use Codwelt\Blog\BlogServiceProvider;
use Codwelt\Blog\Operations\Constants\Path;
use Illuminate\Http\UploadedFile;
use Image;
/**
 * Class ImagePost
 * @package Codwelt\Blog\Operations\Structures
 * @author FuriosoJack <iam@furiosojack.com>
 */
class ImagePost
{

    private $imageName;
    private $uploadFile;


    public function __construct(UploadedFile $uploadFile, $imageName)
    {

        $this->imageName = $imageName;
        $this->uploadFile = $uploadFile;

        $this->imageName = $this->imageName. '.'. $this->uploadFile->extension();

    }

    public function save()
    {
        $this->storageLocal();
    }

    private function getPathHeader()
    {
        return BlogServiceProvider::NAMESPACE_PROYECT . Path::PUBLIC_STORAGE_POST_IMAGES_HEADER;
    }


    private function getPathThum()
    {
        return BlogServiceProvider::NAMESPACE_PROYECT .Path::PUBLIC_STORAGE_POST_IMAGES_THUMBNAIL;

    }
    private function storageLocal()
    {

        $path = $this->getPathHeader();

        $patchImagenHeader = $this->uploadFile->storeAs($path,$this->imageName, 'public');


        ///////Imagen grande
        ///
        ///
        ///

        $patchImagen = storage_path('app/public/'.$patchImagenHeader);


        $img = Image::make($patchImagen)->resize(900,800,function($constraint){
            $constraint->aspectRatio();
        });

        $img->save($patchImagen);


        /////////////Imagen pequeña
        ///
        ///

        $patchImagenMiniatura = $this->uploadFile->storeAs($this->getPathThum(),$this->imageName,'public');

        $patchImagen = storage_path('app/public/'.$patchImagenMiniatura);

        $img = Image::make($patchImagen)->resize(300,300,function($constraint){
            $constraint->aspectRatio();
        });

        $img->save($patchImagen);

    }



    public function getNameInfStorage()
    {
        return $this->imageName;
    }







}