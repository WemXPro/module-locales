<?php

namespace Modules\Locales\Models;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

class Manager
{
    public ?ISO639 $iso639 = null;
    private ?Filesystem $filesystem = null;
    private ?array $languages = null;
    private array $langs = [];
    private Collection $countries;

    public function __construct()
    {
        $this->iso639 = $this->getIsoInstance();
        $this->filesystem = $this->getFilesystemInstance();
        $this->languages = $this->filesystem->directories(resource_path('lang'));
        $this->countries = collect(require module_path('Locales', 'Config/languages.php'));

        foreach ($this->languages as $key => $path) {
            $code = basename($path);
            $this->langs[$code] = $this->iso639->languageByCode1($code);
        }
    }

    public function getInstalled(): array
    {
        return $this->langs;
    }

    public function getAvailable(): array
    {
        foreach ($this->iso639->allLanguages() as $key => $value) {
            $codes[$value[0]] = $value[4];
        }
        return $codes;
    }

    public function getCountryCode($lang_key): string
    {
        if ($this->countries->keyBy('iso-639-1')->get($lang_key)){
            return array_key_first($this->countries->keyBy('iso-639-1')->get($lang_key)['countries']) ?? $lang_key;
        } else {
            return $lang_key;
        }

    }

    /**
     * Return an instance of the ISO639 class for generating names.
     */
    private
    function getIsoInstance(): ISO639
    {
        return app()->make(ISO639::class);
    }

    /**
     * Return an instance of the filesystem for getting a folder listing.
     */
    private
    function getFilesystemInstance(): Filesystem
    {
        return app()->make(Filesystem::class);
    }
}
