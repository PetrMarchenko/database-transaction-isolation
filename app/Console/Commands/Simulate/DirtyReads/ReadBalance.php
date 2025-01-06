<?php

namespace App\Console\Commands\Simulate\DirtyReads;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReadBalance extends Command
{
    protected $signature = 'dirty-reads:read-balance {isolation=READ COMMITTED}';

    protected $description = 'Command helps to simulate read-balance for dirty-reads';

    public function handle()
    {
        $isolation = $this->argument('isolation');

        sleep(1);
        $this->info("---- COMMAND 'Read Balance' is started >>>>");
        DB::statement('SET TRANSACTION ISOLATION LEVEL ' . $isolation);
        $this->info("---- COMMAND 'Read Balance': ISOLATION LEVEL is set to " . $isolation);

        $customer = DB::table('customers')->where('name', 'John Doe')->first();
        $this->info("---- COMMAND 'Read Balance': Balance read as " . $customer->balance);
    }
}
