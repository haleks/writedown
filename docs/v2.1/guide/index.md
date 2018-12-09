# Getting Started

## Installation

### Pulling a Markdown Parser

Install via composer's require command:
```bash
composer require erusev/parsedown-extra
```

Install via your projects' `composer.json`:
```json
{
    ...
    "require": {
        "php": ">=7.1",
        "laravel/framework": "5.6.*",
        "erusev/parsedown-extra": "~0.7"
    },
    ...
}
```

### Pulling The Package

Install via composer's require command:
```bash
composer require haleks/writedown "2.1.*"
```

Install via your projects' `composer.json`:
```json
{
    ...
    "require": {
        "php": ">=7.1",
        "laravel/framework": "5.6.*",
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

::: tip
The trailing `-o` is an optional option which is used to optimize the autoloader and is considered best practice for production use.
:::

### Registering The Package

This package supports Laravel 5.5+ [Package Discovery](https://laravel.com/docs/5.5/packages#package-discovery).

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

## Prerequisites

This project requires that the following packages be previously installed.

### Specifications

- [PHP](https://php.net) 7.1+ / [HHVM](http://hhvm.com) 3.6+
- [Composer](https://github.com/composer/composer)
- [Laravel](https://laravel.com/docs/5.3/installation) 5.5 | 5.6

### Supported Markdown Parser

- [Parsedown](http://parsedown.org) 1.6+
- [Parsedown Extra](http://parsedown.org/extra/) 0.7+
- [Commonmark](http://commonmark.thephpleague.com) 0.15+
- [Markdown](http://michelf.ca/projects/php-markdown/) 1.6+
- [Markdown Extra](https://michelf.ca/projects/php-markdown/extra/) 1.6+
