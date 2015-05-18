# Command for listing composer packages (Laravel 5)

## Installation

Download or clone __ListPackagesCommand.php__ and put into _app/Console/Commands_ folder.

Add the reference to ListPackagesCommand in your _app/Console/_ __Kernel.php__
```
protected $commands = [
	'App\Console\Commands\Inspire',
	'App\Console\Commands\ListPackagesCommand',
];
```

## Usage

List all packages:
```
php artisan list:packages
```

Add version info:
```
php artisan list:packages --ver
```

Add separator dashes for better readibility:
```
php artisan list:packages --separate
```

Order the result by name ascending/descending:
```
php artisan list:packages --order=desc
php artisan list:packages --order=asc
```

Search in the package names:
```
php artisan list:packages --search=laravel
```

Combine options:
```
php artisan list:packages --ver --separate --order=desc --search=laravel
```

## Copyright

&copy; Barna Szalai 2015

## License

[MIT](http://opensource.org/licenses/MIT)

## Contact

twitter: @devartpro  
email: <szalai.b@gmail.com>  
irc: @BarnaSzalai at #laravel.hu/#laravel (freenode)  
slackchat: [https://laravelbp.slack.com](https://laravelbp.slack.com)
