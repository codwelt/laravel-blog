<?php
namespace Codwelt\Blog\Http\Middlewares;

use Codwelt\Blog\Http\Controllers\User\PostController;
use Codwelt\Blog\Models\Config;
use Illuminate\Http\Request;
use Spatie\RobotsMiddleware\RobotsMiddleware as RobotFatherMiddleware;
/**
 * Class RobotsMiddleware
 * @author Juan Diaz - FuriosoJack <iam@furiosojack.com>
 */
class RobotsHTTPMiddleware extends RobotFatherMiddleware
{

    protected function shouldIndex(Request $request)
    {
        if($request->has(PostController::KEY_REQUEST_SEARCH)){
            return Config::getRobotsArray()['search'];
        }
        return true;
    }

}