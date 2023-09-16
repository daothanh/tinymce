# TinyMce Component for Filamentphp 3

## Integration

- TinyMCE 6
- [Laravel Filemanager](https://github.com/UniSharp/laravel-filemanager)

## Installation

You can install the package via composer:

```bash
composer require daothanh/tinymce
```
Publish the assets:
```bash
php artisan vendor:publish --tag="daothanh-tinymce-assets"
```
Publish the Laravel Filemanager’s config and assets :
```bash
php artisan vendor:publish --tag=lfm_config
php artisan vendor:publish --tag=lfm_public
```
Create symbolic link :
```bash
php artisan storage:link
```
Optionally, you can publish the config file for customization:

```bash
php artisan vendor:publish --tag="daothanh-tinymce-config"
```
## Usage

```php
use Daothanh\Tinymce\Forms\Components\TinymceField;

TinymceField::make('description');
```

## Customization

### Simple editor

To use a predefined simple editor, you may use the profile() method:
```php
TinymceField::make('description')->profile('simple');
```
