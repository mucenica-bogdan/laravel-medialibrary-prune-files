<?php

namespace Falcon\MediaLibrary\Console\Commands;

use Illuminate\Console\Command;

class Prune extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media-library:prune-files {--dry-run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all the files that do not have a Media model record in the DB';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $files = [];
        
        dd($files);
    }
}
