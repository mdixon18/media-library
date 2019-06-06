<?php
use Mdixon18\MediaLibrary\PathGenerator;

return [
    /**
     * The filesystems on which to store added files and derived images by default. Choose
     * one or more of the filesystems you've configured in config/filesystems.php.
     * 
     * e.g. s3
     */
    'disk' => 'public',

    /*
     * The maximum file size of an item in bytes.
     * Adding a larger file will result in an exception.
     */
    'max_file_size' => 1024 * 1024 * 10,

    /*
     * The class that contains the strategy for determining a media file's path.
     */
    'path_generator' => PathGenerator::class,

    /**
     * Lock down routing to a specific middleware, use array for multiple middlewares.
     */
    'middleware' => null,
];