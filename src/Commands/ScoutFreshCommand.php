<?php

namespace Wasinpwg\ScoutRefresh\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ScoutFreshCommand extends Command
{
    public $signature = 'scout:fresh';

    public $description = 'Delete all search indexes and re-import searchable models.';

    public function handle()
    {
        $this->call('scout:delete-all-indexes');
        $modelsDirectory = app_path('Models');
        $files = File::allFiles($modelsDirectory);
        foreach ($files as $file) {
            $relativePath = $file->getRelativePath($modelsDirectory);
            $namespaceDirectory = str_replace('/', '\\', $relativePath ? $relativePath.'\\' : '');
            $modelName = 'App\\Models\\'.$namespaceDirectory.class_basename($file->getBasename('.php'));
            if (class_exists($modelName) && method_exists($modelName, 'shouldBeSearchable') && ! trait_exists($modelName)) {
                $this->call('scout:import', ['model' => $modelName]);
                $this->newLine();
            }
        }
        $this->call('scout:sync-index-settings');

        return Command::SUCCESS;
    }
}
