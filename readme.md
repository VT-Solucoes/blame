# Automatic `created_by`, `updated_by`, and `deleted_by` model attributes.

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

`deleted_at` will only be written if the given model uses Soft Deletes.

There is also a `Blueprint` macro, `blameColumns` that you can use in your migrations.

### License

MIT. Do as you wish.
