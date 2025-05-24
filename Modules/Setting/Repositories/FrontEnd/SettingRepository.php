<?php

namespace Modules\Setting\Repositories\FrontEnd;

use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Setting;

class SettingRepository
{
    function __construct(DotenvEditor $editor)
    {
        $this->editor = $editor;
    }

    public function set($request)
    {
        $this->saveSettings($request->except('_token', '_method'));

				return true;
    }

    public function saveSettings($request)
    {
        foreach ($request as $key => $value) {

            if ($key == 'translate')
                  static::setTranslatableSettings($value);

            if ($key == 'images')
                  static::setImagesPath($value);

            if ($key == 'env')
                  static::setEnv($value);

            Setting::set($key, $value);
        }
    }

    public static function setTranslatableSettings($settings = [])
    {
        foreach ($settings as $key => $value) {
            Setting::lang(locale())->set($key, $value);
        }
    }

    public static function setImagesPath($settings = [])
    {
        foreach ($settings as $key => $value) {
            Setting::set($key, path_without_domain($value));
        }
    }

    public static function setEnv($settings = [])
    {
        foreach ($settings as $key => $value) {
            $file = DotenvEditor::setKey($key, $value, '', false);
        }

        $file = DotenvEditor::save();
    }
}
