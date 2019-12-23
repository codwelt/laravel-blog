<?php


namespace Codwelt\Blog\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BasicController;

/**
 * Class Controller
 * @package CodWelt\Blog\Controllers
 * @author FuriosoJack <iam@furiosojack.com>
 */
class Controller extends BasicController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

}