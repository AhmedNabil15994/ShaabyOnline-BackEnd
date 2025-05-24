<?php

namespace Modules\Setting\Repositories\Dashboard;

use Illuminate\Support\Facades\File;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Modules\Core\Traits\CoreTrait;
use Setting;

class SettingRepository
{
    use CoreTrait;

    protected $editor;

    function __construct(DotenvEditor $editor)
    {
        $this->editor = $editor;
    }

    public function set($request)
    {
        $this->saveSettings($request->except('_token', '_method', 'images'));

        return true;
    }

    public function saveSettings($request)
    {
        foreach ($request as $key => $value) {

            if ($key == 'translate')
                static::setTranslatableSettings($value);

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

    public static function setImagesPathFromFileUpload($settings = [], $parent = '')
    {
        foreach ($settings as $key => $value) {
            if ($value) {
                if ($parent)
                    $oldPath = config('setting')[$parent][$key] ?? null;
                else
                    $oldPath = config('setting')[$key] ?? null;

                if ($oldPath) {
                    File::delete($oldPath); ### Delete old image
                }
                $imgName = static::uploadImage(public_path(config('core.config.settings_img_path')), $value);
                $imgPath = config('core.config.settings_img_path') . '/' . $imgName;
                Setting::set($parent . '.' . $key, $imgPath);
            }
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
