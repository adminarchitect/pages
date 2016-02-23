# Admin Architect - Pages module
`adminarchitect/pages` provides the default skeleton for Admin Architect pages module.
It includes Pages module out of the box as like as eloquent model and pages repository.

## Installation

`Note:` this is not standalone package, it can be used only in conjunction with `Admin Architect` (`terranet/administrator`) package.

then require it:

```
composer require adminarchitect/pages
```

register Pages service provider by adding to the app/config.php `providers` section:

```
'providers' => [
	...
	Terranet\Pages\ServiceProvider::class
	...
]
```

now you can publish the whole package resources by running:

```
php artisan vendor:publish [--provider="Terranet\\Pages\\ServiceProvider"]
```

## Modules
`Pages` module will be copied into the `app\Http\Terranet\Administrator\Modules` directory.

## Models
Associated eloquent model `Page` will be added as well to `app` directory.

## Routes
Routes become available at `app\Http\Terranet\Pages\routes.php`.

## Migrations
Run artisan command to create migration:

```
php artisan pages:table
```

this will create the migration file inside of `database/migrations` directory...

Run migration:
```
php artisan migrate
```

*Enjoy!*
