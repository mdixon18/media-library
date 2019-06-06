<?php

namespace Mdixon18\MediaLibrary\Models;

use Spatie\Image\Image;
use Spatie\MediaLibrary\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    public function image()
    {
        return Image::load($this->getFullUrl());
    }

    public function downloadUrl()
    {
        return config('media-library.app_path', '') . "/download/{$this->id}";
    }

    public function registerMediaConversions(BaseMedia $media = null)
    {
    }
}
