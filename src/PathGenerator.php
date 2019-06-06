<?php

namespace Mdixon18\MediaLibrary;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator as BasePathGenerator;

class PathGenerator implements BasePathGenerator
{
    /*
     * Get the path for the given media, relative to the root storage path.
     */
    public function getPath(Media $media) : string
    {
        return '/';
    }

    /*
     * Get the path for conversions of the given media, relative to the root storage path.
     */
    public function getPathForConversions(Media $media) : string
    {
        return $this->getPath($media);
    }

    /*
     * Get the path for responsive images of the given media, relative to the root storage path.
     */
    public function getPathForResponsiveImages(Media $media) : string
    {
        return $this->getPath($media);
    }
}