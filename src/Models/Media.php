<?php

namespace Mdixon18\MediaLibrary\Models;

use Spatie\Image\Image;
use Spatie\MediaLibrary\Models\Media as BaseMedia;
use Mdixon18\MediaLibrary\MediaLibrary;

class Media extends BaseMedia
{
    public function image()
    {
        return Image::load($this->getFullUrl());
    }

    public function downloadUrl()
    {
        return url(config('media-library.route_path', '') . "/download/{$this->id}");
    }

    public function registerMediaConversions(BaseMedia $media = null)
    {
    }

    public function scopeSearch($query)
    {
        if (request('search') && filled(request('search'))) {
            $search = request('search');
            $query->where(function($q) use($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('file_name', 'like', "%{$search}%")
                    ->orWhere('mime_type', 'like', "%{$search}%")
                    ->orWhere('alt_text', 'like', "%{$search}%")
                    ->orWhere('caption', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    public function scopeFilterMimes($query) 
    {
        $types = [];
        if (request('filetypes') && !empty(explode(',', request('filetypes')))) {
            $filetypes = explode(',', request('filetypes'));
            if (!empty($filetypes)) {
                foreach ($filetypes as $type) {
                    $types[] = ".{$type}";
                }
            }
        }

        if (!empty($types)) {
            $query->where(function($q) use($types) {
                foreach ($types as $key => $type) {
                    if ($key == 0) {
                        $q->where('file_name', 'like', "%{$type}%");
                    } else {
                        $q->orWhere('file_name', 'like', "%{$type}%");
                    }
                }
            });
        }

        return $query;
    }
}
