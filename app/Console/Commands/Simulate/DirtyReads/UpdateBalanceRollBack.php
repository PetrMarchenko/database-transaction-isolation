<?php

namespace App\Console\Commands\Simulate\DirtyReads;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateBalanceRollBack extends Command
{
    protected $signature = 'dirty-reads:update-balance-rollback {isolation=READ COMMITTED}';

    protected $description = 'Command helps to simulate read-balance for dirty-reads.';

    public function handle()
    {
        $isolation = $this->argument('isolation');
        $this->info("-- COMMAND 'Update Balance' is started >>");

        DB::statement('SET TRANSACTION ISOLATION LEVEL ' . $isolation);
        $this->info("-- COMMAND 'Update Balance': ISOLATION LEVEL is set to " . $isolation);

        DB::beginTransaction();

        $balance = 1200;
        DB::table('customers')->where('name', 'John Doe')->update(['balance' => $balance]);

        $customer = DB::table('customers')->where('name', 'John Doe')->first();
        $this->info("-- COMMAND 'Update Balance': Balance updated to $customer->balance");

        $this->info("-- COMMAND 'Update Balance': Sleeping for 5 seconds ...");
        sleep(5);
        $this->info("-- COMMAND 'Update Balance': Waking up after sleep");

        $this->info("-- COMMAND 'Update Balance': Rolling back transaction <<");
        DB::rollBack();

        $customer = DB::table('customers')->where('name', 'John Doe')->first();
        $this->info("-- COMMAND 'Update Balance': Balance read as $customer->balance");
    }
}
