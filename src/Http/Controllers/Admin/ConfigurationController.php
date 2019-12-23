<?php
/**
 * Created by PhpStorm.
 * User: Juan
 * Date: 26/06/2018
 * Time: 04:51 PM
 */

namespace Codwelt\Blog\Http\Controllers\Admin;
use Codwelt\Blog\BlogServiceProvider;
use Codwelt\Blog\Http\Controllers\Controller;
use Codwelt\Blog\Http\Requests\Admin\UpdateConfigRequest;
use Codwelt\Blog\Models\Config;
use Illuminate\Http\Request;

/**
 * Class ConfigurationController
 * @package CodWelt\Blog\Http\Controllers\Admin
 * @author Juan Diaz - FuriosoJack <iam@furiosojack.com>
 */
class ConfigurationController extends Controller
{


    public function index()
    {
        $configs = Config::all()->toArray();
        return view(BlogServiceProvider::NAMESPACE_PROYECT.'::Admin.Config.index',[
            'configs' => $configs
        ]);
    }

    public function update(UpdateConfigRequest $request)
    {
        //Se obtiene solo los datos del request que esten en la reglas
        $requestFiltrador = $request->only(array_keys(UpdateConfigRequest::RULES));

        foreach ($requestFiltrador as $configKey => $configValue){
            //Recorrido de las configuraciones a actualizar

            Config::where('name',$configKey)->update([
                'value' => $configValue
            ]);
        }

        return redirect()->back();

    }

}