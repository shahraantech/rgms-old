<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProbabtionPeriodUpdateJob;

class UpdateProbPeriodCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'probabition:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update probabition period when it completed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       dispatch(new ProbabtionPeriodUpdateJob());
    }
}
