# Installation

- [Pulling a Markdown Parser](#pulling-a-markdown-parser)
- [Pulling The Package](#pulling-the-package)
- [Registering The Package](#registering-the-package)

## Pulling a Markdown Parser

Install via composer's require command:
```bash
composer require erusev/parsedown-extra
```

Install via your projects' `composer.json`:
```json
{
    ...
    "require": {
        "php": ">=7.0",
        "laravel/framework": "5.5.*",
        "erusev/parsedown-extra": "~0.7"
    },
    ...
}
```

## Pulling The Package

Install via composer's require command:
```bash
composer require haleks/writedown
```

Install via your projects' `composer.json`:
```json
{
    ...
    "require": {
        "php": ">=7.0",
        "laravel/framework": "5.5.*",
        "erusev/parsedown-extra": "~0.7",
        "haleks/writedown": "2.1.*"
    },
    ...
}
```

Once the package is in the require section you will need to run composer's `install` or `update` command to pull in the code:
```bash
# Install
composer install -o

# or Update
composer update -o
```
<sup>**Note**: The trailing `-o` is an optional option which is used to optimize the autoloader and is considered best practice.</sup>

## Registering The Package

This package supports Laravel 5.5 [Package Discovery](https://laravel.com/docs/5.5/packages#package-discovery).

If you have opted out of Package Discovery you will need to register the package manually. Once the package has been successfully pulled you will need to register the package's service provider to the Laravel's app and optionally add the package's facade by modifying `config/app.php`:

```php
...
    'providers' => [
        ...
        Haleks\Writedown\WritedownServiceProvider::class,

    ],
...

    'aliases' => [
        ...
        // Optional facade
        'Writedown' => Haleks\Writedown\Facades\Writedown::class,

    ],
...
```
