<?php

namespace Modules\DeveloperTools\Http\Controllers\Themes;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Modules\Core\Traits\Dashboard\ControllerResponse;
use Setting;

class ColorController extends Controller
{
    use ControllerResponse;

    public function index()
    {
        $color_sections = config('fronttheme.site_colors_sections');
        $colors_values = json_decode(file_get_contents(module_path('DeveloperTools', 'site_colors.json')),true);

        return view('developertools::themes.colors.index',compact('color_sections','colors_values'));
    }

    public function update(Request $request)
    {
        $build_colors = $this->buildVars($request);
        file_put_contents(public_path('frontend/css/vars.css'),$build_colors['style']);
        file_put_contents(module_path('DeveloperTools', 'site_colors.json'),$build_colors['config']);

        Setting::set('theme_sections', $request->theme_sections);
        return $this->updatedResponse([], [true, __('apps::dashboard.messages.updated')]);
    }

    private function buildVars(Request $request){

        $colors = ($request->except('_token','_method','theme_sections'));
        $style = ':root {';
        $config = array();

        foreach ($colors as $key => $value){
            $style .= $key . ':'.$value.';';
            $config[$key] = $value;
        }

        $style .= '}';

        $config = str_replace([',"' , '{' , '}'] , [
            ',
        "' ,
            '{
        ',
            '
            }'
        ], json_encode($config));

        $style = str_replace([';' , '{' , '}'] , [
            ';
        ' ,'{
        ',
            '
            }'
        ], $style);

        return ['style' => $style , 'config' => $config];
    }
}
