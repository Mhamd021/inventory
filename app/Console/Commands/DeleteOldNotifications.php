<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DeleteOldNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete notifications older than 6 days';

    public function __construct()
    {
         parent::__construct();
    }

    public function handle()
    {
        $cutoffDate = Carbon::now()->subDays(7);
        DB::table('notifications') ->where('created_at', '<', $cutoffDate) ->delete();
        $this->info('Old notifications deleted successfully.');

    }
}
