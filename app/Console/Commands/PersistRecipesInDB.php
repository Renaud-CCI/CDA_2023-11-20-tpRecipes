<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ImporterJob;

class PersistRecipesInDB extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recipes:persist {filename=recipes.json}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'persist recipes and ingredients in database with a json file';

    /**
     * Execute the console command.
     */



    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Importing recipes...');
        ImporterJob::dispatch($this->argument('filename'));
        $this->info('Recipes imported successfully!');
    }
}