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
        $files = File::files($modelsDirectory);
        foreach ($files as $file) {
            $modelName = 'App\\Models\\'.$file->getBasename('.php');
            $model = new $modelName();
            if (method_exists($model, 'shouldBeSearchable')) {
                $this->call('scout:import', ['model' => $modelName]);
                $this->newLine();
            }
        }
        $this->call('scout:sync-index-settings');

        return Command::SUCCESS;
    }
}
