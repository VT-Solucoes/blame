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

### Default user id

If you're mutating models in non-authenticated contexts and you wish to write a default user id on create, update, or delete, you can set the `blame.user.default_id` config key to an integer. By default this key is null. 

### Manual override

If you set a value manually (eg `$model->created_at = 1`), this value will be written to the database instead of the automatic value. This is useful for contexts where you don't have an authenticated user (eg when creating models via the console) and you still wish to write an id.

### Model trait

You'll probably want relations, in which case you can use `Relations` trait which provides `created_by`, `updated_by` and `deleted_by` relations. You can of course opt not to use this trait and define your own relation methods however you like.

### Blueprint macro

There is also a `Blueprint` macro, `blameColumns` that you can use in your migrations.

### License

MIT. Do as you wish.
