<?php

namespace Daothanh\Tinymce;

use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;

class TinymceServiceProvider extends ServiceProvider
{
    public function boot() {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'daothanh-tinymce');
        $this->mergeConfigFrom(__DIR__.'/../config/daothanh-tinymce.php', 'daothanh-tinymce');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->publishes([__DIR__.'/../config/daothanh-tinymce.php' => config_path('daothanh-tinymce.php')], 'daothanh-tinymce-config');
        $this->publishes([__DIR__.'/../assets/' => public_path('vendor/daothanh-tinymce')], 'daothanh-tinymce-assets');

        $assets = [
            Js::make('tinymce', asset('vendor/daothanh-tinymce/js/tinymce/tinymce.min.js')),
        ];
        $files = scandir(__DIR__.'/../assets/js/tinymce/langs/');
        foreach($files as $file) {
            if (str_contains($file, '.js')) {
                $lang = substr($file, 0, strpos($file, '.js'));
                $assets[] = Js::make('tinymce-lang-'.$lang, asset('vendor/daothanh-tinymce/js/tinymce/langs/'.$file))->loadedOnRequest();
            }
        }
        FilamentAsset::register($assets, package: 'daothanh-tinymce');
    }
}
