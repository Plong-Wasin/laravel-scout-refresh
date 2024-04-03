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
<<<<<<< HEAD
            $relativePath = $file->getRelativePath();
            $namespaceDirectory = str_replace('/', '\\', $relativePath ? $relativePath . '\\' : '');
            $modelName = 'App\\Models\\' . $namespaceDirectory . class_basename($file->getBasename('.php'));
            if (class_exists($modelName) && method_exists($modelName, 'shouldBeSearchable') && !trait_exists($modelName)) {
=======
            $relativePath = $file->getRelativePath($modelsDirectory);
            $namespaceDirectory = str_replace('/', '\\', $relativePath ? $relativePath.'\\' : '');
            $modelName = 'App\\Models\\'.$namespaceDirectory.class_basename($file->getBasename('.php'));
            if (class_exists($modelName) && method_exists($modelName, 'shouldBeSearchable') && ! trait_exists($modelName)) {
>>>>>>> a67c1292ec4fb68d20940b50d09194a33ef9e25a
                $this->call('scout:import', ['model' => $modelName]);
                $this->newLine();
            }
        }
        $this->call('scout:sync-index-settings');

        return Command::SUCCESS;
    }
}
