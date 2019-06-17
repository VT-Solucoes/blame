[![Build Status](https://travis-ci.org/DeBoerTool/model-factory.svg?branch=master)](https://travis-ci.org/DeBoerTool/model-factory)
[![Latest Stable Version](https://poser.pugx.org/dbt/model-factory/v/stable)](https://packagist.org/packages/dbt/model-factory)
[![License](https://poser.pugx.org/dbt/model-factory/license)](https://packagist.org/packages/dbt/model-factory)


# Class-based Model Factories for Laravel

This package is alternative to keeping your model factories in plain PHP files. 

## Getting Started
### Prerequisites

This package requires PHP 7.1.3 or higher, `illuminate/support@^5.7`, and `illuminate/database@^5.7`.

### Installing

Via Composer:

```bash
composer require dbt/blame
``` 

### Testing

Run:

```bash
composer test
```

## Usage

Publish the `blame.php` configuration file with the `php artisan vendor:publish` command, or copy the file from this repository. The service provider should be auto-discovered.

In your configuration file, add the models you wish to observe:

```php
    'models' => [
        App\MyModel::class
    ],
```

You can also use the config file to customize the column names and swap out the observer if you wish.

### License

MIT. Do as you wish.
