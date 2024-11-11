![Tests](https://github.com/meops/laravel-populate/actions/workflows/test.yml/badge.svg)
# Laravel Populate
An Artisan command for populating your database. It allows you to quickly create records in your database using the model factories you have already defined in your Laravel application without writing seeders.
## Installation
Install the package as a development dependency:    
```bash
composer require --dev meops/laravel-populate
```
## Usage
Records are created by specifying the model whose factory definition should be used to generate field values.

### Create a single record
The first argument specifies the model to create. The package will look for a matching model name in the `App/Models` directory by default:
```php
php artisan db:populate User
```
Use double backslashes to escape slashes in a fully qualified class name:
```php
php artisan db:populate MyNamespace\\User
```
### Create multiple records
The second argument is optional and specifies the number of records to create:
```php
php artisan db:populate User 10
```
### Create multiple records with custom data
Specify any fields whose values should be overriden using the `-o` option with the format `field=value`. Multiple fields may be specified by providing multiple `-o` options.
```php
php artisan db:populate User -o email=me@example.com -o password=secret
```
