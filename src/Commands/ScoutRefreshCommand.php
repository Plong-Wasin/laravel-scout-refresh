<?php

namespace Wasinpwg\ScoutRefresh\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ScoutRefreshCommand extends Command
{
    public $signature = 'scout:refresh';

    public $description = 'Delete and re-import all search indexes for searchable models.';

    public function handle()
    {
        $modelsDirectory = app_path('Models');
        $files = File::allFiles($modelsDirectory);
        foreach ($files as $file) {
            $relativePath = $file->getRelativePath();
            $namespaceDirectory = str_replace('/', '\\', $relativePath ? $relativePath.'\\' : '');
            $modelName = 'App\\Models\\'.$namespaceDirectory.class_basename($file->getBasename('.php'));
            if (class_exists($modelName) && method_exists($modelName, 'shouldBeSearchable') && ! trait_exists($modelName)) {
                $this->call('scout:flush', ['model' => $modelName]);
                $this->call('scout:import', ['model' => $modelName]);
                $this->newLine();
            }
        }
        $this->call('scout:sync-index-settings');

        return Command::SUCCESS;
    }
}
