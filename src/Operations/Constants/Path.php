<?php


namespace Codwelt\Blog\Operations\Constants;


use Codwelt\Blog\BlogServiceProvider;

/**
 * Class Path
 * @package Codwelt\Blog\Operations\Constants
 * @author FuriosoJack <iam@furiosojack.com>
 */
class Path
{

    const PUBLIC_STORAGE_POST = "/posts";
    const PUBLIC_STORAGE_POST_IMAGES = self::PUBLIC_STORAGE_POST.'/imagenes';
    const PUBLIC_STORAGE_POST_IMAGES_HEADER = self::PUBLIC_STORAGE_POST_IMAGES . '/headers';
    const PUBLIC_STORAGE_POST_IMAGES_THUMBNAIL = self::PUBLIC_STORAGE_POST_IMAGES . '/miniaturas';

}