<?php

namespace Daothanh\Tinymce\Forms\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Concerns;
use Filament\Forms\Components\Contracts;

class TinymceField extends Field implements Contracts\CanBeLengthConstrained, Contracts\HasFileAttachments
{
    use Concerns\HasPlaceholder;
    use Concerns\CanBeLengthConstrained;
    use Concerns\HasFileAttachments;

    protected string $view = 'daothanh-tinymce::forms.components.tinymce-field';

    protected string $language;

    protected bool $showMenuBar = false;

    protected string $plugins = 'advlist codesample directionality emoticons fullscreen image link lists media table wordcount';

    protected string $profile = 'default';

    protected string $toolbar;

    protected bool $toolbarSticky = false;

    // TinyMCE var: relative_urls
    protected bool $relativeUrls = false;

    // TinyMCE var: remove_script_host
    protected bool $removeScriptHost = true;

    // TinyMCE var: convert_urls
    protected bool $convertUrls = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->language = app()->getLocale();
    }

    public function getLanguage(): string
    {
        return match ($this->language) {
            'ar' => 'ar',
            'az' => 'az',
            'bg' => 'bg_BG',
            'bn' => 'bn_BD',
            'ca' => 'ca',
            'cs' => 'cs',
            'cy' => 'cy',
            'da' => 'da',
            'de' => 'de',
            'dv' => 'dv',
            'el' => 'el',
            'eo' => 'eo',
            'es' => 'es',
            'et' => 'et',
            'eu' => 'eu',
            'fa' => 'fa',
            'fi' => 'fi',
            'fr' => 'fr_FR',
            'ga' => 'ga',
            'gl' => 'gl',
            'he' => 'he_IL',
            'hr' => 'hr',
            'hu' => 'hu_HU',
            'hy' => 'hy',
            'id' => 'id',
            'is' => 'is_IS',
            'it' => 'it',
            'ja' => 'ja',
            'kab' => 'kab',
            'kk' => 'kk',
            'ko' => 'ko_KR',
            'ku' => 'ku',
            'lt' => 'lt',
            'lv' => 'lv',
            'nb' => 'nb_NO',
            'nl' => 'nl',
            'oc' => 'oc',
            'pl' => 'pl',
            'pt' => 'pt_BR',
            'ro' => 'ro',
            'ru' => 'ru',
            'sk' => 'sk',
            'sl' => 'sl',
            'sq' => 'sq',
            'sr' => 'sr',
            'sv' => 'sv_SE',
            'ta' => 'ta',
            'tg' => 'tg',
            'th' => 'th_TH',
            'tr' => 'tr',
            'ug' => 'ug',
            'uk' => 'uk',
            'vi' => 'vi',
            'zh' => 'zh-Hans',
            default => 'en',
        };
    }

    public function language(string $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getToolbarSticky(): bool
    {
        return $this->toolbarSticky;
    }

    public function toolbarSticky(bool $toolbarSticky): static
    {
        $this->toolbarSticky = $toolbarSticky;

        return $this;
    }

    public function getShowMenuBar(): bool
    {
        return $this->showMenuBar;
    }

    public function getToolbar(): string
    {
        if (config('daothanh-tinymce.profiles.' . $this->profile . '.toolbar')) {
            return config('daothanh-tinymce.profiles.' . $this->profile . '.toolbar');
        }

        return 'undo redo removeformat | formatselect fontsizeselect | bold italic | rtl ltr | alignjustify alignright aligncenter alignleft | numlist bullist | forecolor backcolor | blockquote table toc hr | image link media codesample emoticons | wordcount fullscreen';
    }

    public function getPlugins(): string
    {
        if (config('daothanh-tinymce.profiles.' . $this->profile . '.plugins')) {
            return config('daothanh-tinymce.profiles.' . $this->profile . '.plugins');
        }

        return $this->plugins;
    }

    public function getFileAttachmentsDirectory(): ?string
    {
        return filled($directory = $this->evaluate($this->fileAttachmentsDirectory)) ? $directory : config('daothanh-tinymce.profiles.' . $this->profile . '.upload_directory');
    }

    public function profile(string $profile): static
    {
        $this->profile = $profile;

        return $this;
    }

    public function getRelativeUrls(): bool
    {
        return $this->relativeUrls;
    }

    public function setRelativeUrls(bool $relativeUrls): static
    {
        $this->relativeUrls = $relativeUrls;

        return $this;
    }

    public function getRemoveScriptHost(): bool
    {
        return $this->removeScriptHost;
    }

    public function setRemoveScriptHost(bool $removeScriptHost): static
    {
        $this->removeScriptHost = $removeScriptHost;

        return $this;
    }

    public function getConvertUrls(): bool
    {
        return $this->convertUrls;
    }

    public function setConvertUrls(bool $convertUrls): static
    {
        $this->convertUrls = $convertUrls;

        return $this;
    }

    public function getFileManagerPath()
    {
        return config('daothanh-tinymce.file_manager');
    }
}
