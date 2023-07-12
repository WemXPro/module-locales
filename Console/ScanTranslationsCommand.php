<?php

namespace Modules\Locales\Console;

use FilesystemIterator;
use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ScanTranslationsCommand extends Command
{
    protected $signature = 'translations:scan {directory : Path to the folder}';

    protected $description = 'Scanning files and extracting trans() function keys and values';

    public function handle(): void
    {
        $directory = $this->argument('directory');
        $translations = [];

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        $pattern = '/trans\([\'"]([^\'"]+)[\'"],\s*\[[^\]]*\'default\'\s*=>\s*([\'"][^\'"]+[\'"])\]/';

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $content = file_get_contents($file->getPathname());

                $matches = [];
                preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

                foreach ($matches as $match) {
                    $key = $match[1];
                    $value = $match[2];
                    $translations[$key] = $value;
                }
            }
        }

        $this->warn('Знайдені ключі та значення функції trans() __() @trans():');
        foreach ($translations as $key => $value) {
            $this->info( "'{$key}' => {$value},");
        }
    }
}
