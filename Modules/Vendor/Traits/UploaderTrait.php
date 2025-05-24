<?php

namespace Modules\Vendor\Traits;

use Storage;
use Image;
use File;

trait UploaderTrait
{
    static public function base64($imgUrl, $newFolder = null, $commonFolder = null)
    {
        $path = $imgUrl;

        $type = $imgUrl->getClientOriginalExtension() ? $imgUrl->getClientOriginalExtension() : 'jpg';

        $imgname = md5(rand() * time()) . '.' . $type;

        $folder = 'photos/shares';

        if ($commonFolder != null) {
            $folder = self::createFolder($folder . '/' . $commonFolder);
        }

        if ($newFolder != null) {
            $folder = self::createFolder($folder . '/' . $newFolder);
        }

        $storageUrl = $folder . '/' . $imgname;

        Storage::disk('public')->put($storageUrl, Image::make($path)->encode());

        return Storage::url($storageUrl);
    }


    static public function createFolder($path)
    {
        if (Storage::disk('public')->exists($path)) {
            return $path;
        } else {
            Storage::disk('public')->makeDirectory($path);
            return $path;
        }
    }

}
