<?php

namespace Falcon\MediaLibrary\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\Finder\SplFileInfo;

class Prune extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media-library:prune-files {path} {--disk=local} {--dry-run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all the files that do not have a Media model record in the DB';

    protected FilesystemAdapter $disk;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->disk = Storage::disk($this->option('disk'));
        $mediaFolders = $this->getMediaDirectories();

        $toRemove = [];
        $this->info(__('Computing media list'));
        $this->withProgressBar($mediaFolders, function(string $path) use (&$toRemove) {
            if(!Media::where(['id' => basename($path)])->exists()) {
                $toRemove []= $path;
            }
        });

        $this->newLine();

        if($this->option('dry-run')) {
            $this->table([__('Paths')], collect($toRemove)->map(fn($path) => [$path])->toArray());
            return 0;
        }

        $this->info(__('Cleaning up'));

        $this->withProgressBar($toRemove, function(string $path) {
            $this->disk->deleteDirectory($path);
        });

        $this->newLine();

        return 0;
    }

    protected function getMediaDirectories(): array
    {
        $mediaDirectories = [];
        $basePath = $this->argument('path');
        $directories = $this->disk->allDirectories($basePath);

        foreach ($directories as $directory) {
            if ($this->isMediaDirectory($directory)) {
                $mediaDirectories [] = $directory;
            }
        }

        return $mediaDirectories;
    }

    protected function isMediaDirectory(string $path): bool
    {
        $reservedDirectoryNames = ['responsive-images', 'conversions'];

        $pathName = basename($path);

        if(!is_numeric($pathName)) {
            return false;
        }

        if(in_array($pathName, $reservedDirectoryNames)) {
            return false;
        }

        $files = $this->disk->files($path);
        if(empty($files)) {
            return false;
        }

        $directories = $this->disk->directories($path);
        if(empty($directories)) {
            return true;
        }

        foreach($directories as $directory) {
            $directoryName = basename($directory);
            if(in_array($directoryName, $reservedDirectoryNames)) {
                return true;
            }
        }
        
        return false;
    }
}
