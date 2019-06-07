# Laravel Media Library

This package has an accompanying vue package that can be found [here](https://github.com/mdixon18/vue-medialibrary).

## Installation
```
composer require mdixon18/media-library
```

This package will automatically register itself.

You can publish the migration with:
```
php artisan vendor:publish --provider="Mdixon18\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"
```

You will then need to migrate in order to create the ```media``` table.
```
php artisan migrate
```

You can publish the configuration file with:
```
php artisan vendor:publish --provider="Mdixon18\MediaLibrary\MediaLibraryServiceProvider" --tag="config"
```

## Usage
In order for the API calls to work from the vue component you will need to add our routes to you application.
```
MediaLibrary::routes();
```

If you wrap these within any form of route group with a prefix please remember to update the ```route_path``` in the config file.