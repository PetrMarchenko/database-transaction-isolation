<?php

namespace App\Console\Commands\Simulate\NonRepeatableReads;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReadBalance extends Command
{
    protected $signature = 'non-repeatable-reads:read-balance {isolation=READ COMMITTED}';

    protected $description = 'Command helps to simulate read-balance for non-repeatable reads';

    public function handle()
    {
        $isolation = $this->argument('isolation');

        $this->info("-- COMMAND 'Read Balance' is started >>");
        DB::statement('SET TRANSACTION ISOLATION LEVEL ' . $isolation);
        $this->info("-- COMMAND 'Read Balance': ISOLATION LEVEL is set to " . $isolation);

        DB::beginTransaction();

        $customer = DB::table('customers')->where('name', 'John Doe')->first();
        $this->info("-- COMMAND 'Read Balance': Balance read as " . $customer->balance);

        $this->info("-- COMMAND 'Read Balance': Sleeping for 5 seconds ...");
        sleep(5);
        $this->info("-- COMMAND 'Read Balance': Waking up after sleep");

        $this->info("-- COMMAND 'Read Balance': Next read balance");
        $customer = DB::table('customers')->where('name', 'John Doe')->first();
        $this->info("-- COMMAND 'Read Balance': Balance read as " . $customer->balance);

        DB::commit();
    }
}
