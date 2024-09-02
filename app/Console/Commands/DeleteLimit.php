<?php

namespace App\Console\Commands;

use App\Models\RequestLimit;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteLimit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-limit';

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
        $createdLimitTimes = RequestLimit::all();
        $nowTime = Carbon::now();
        foreach ($createdLimitTimes as $key => $createdLimitTime) {
            $limitCreateTime = Carbon::parse($createdLimitTime->created_at);
            if ($limitCreateTime->isBefore($nowTime->subDay())) {
                $createdLimitTime->delete();
            }


            // Three Minute Por hole Delete Limit

            // Calculate the time threshold (3 minutes ago)
            // $thresholdTime = $nowTime->subMinutes(3);

            // Fetch and delete records older than 3 minutes
            //   RequestLimit::where('created_at', '<', $thresholdTime)->delete();
        }




        $this->info('Command Run Ok');
        return 0;
    }
}
