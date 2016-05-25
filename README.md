# LaravelApiClientProvider
An ApiClientProvider for Laravel.

## Installation

### Composer
Add Laravel Api Client to your composer.json file.
```
"triadev/LaravelApiClientProvider": "1.*"
```

Run `composer install` to get the latest version of the package.

### Manually
It's recommended that you use Composer, however you can download and install from this repository.

### Laravel
Open `config/app.php` and find the `providers` key. Add `ApiClientServiceProvider` to the array:
```
...
Triadev\LaravelApiClientProvider\ApiClientServiceProvider::class
...
```

You can also add an alias to the list of class aliases in the same file.
```
'ApiClientManager' => Triadev\LaravelApiClientProvider\Facade\ApiClientManagerFacade::class,
```

## Config

### Config Files
In order to edit the default configuration for this package you may execute:
```
php artisan vendor:publish --provider="Triadv\LaravelApiClientProvider\ApiClientServiceProvider"
```

After that, `config/laravelapiclient.php` will be created.
Inside this file you will find all the fields that can be edited in this package.