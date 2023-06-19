<?php

namespace Wasinpwg\ScoutRefresh\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ScoutRefreshCommand extends Command
{
    public $signature = 'scout:refresh';

    public $description = 'Refreshes the search index by re-importing the searchable models in the application.';

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
