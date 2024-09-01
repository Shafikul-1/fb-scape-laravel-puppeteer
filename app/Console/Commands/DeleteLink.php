<?php

namespace App\Console\Commands;

use App\Http\Controllers\CollectDataController;
use Illuminate\Console\Command;

class DeleteLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $collecting = new CollectDataController();
         // Link linkDelete
         $linkDelete = $collecting->linkDelete();
         $this->info($linkDelete);


         return 0;
    }
}
