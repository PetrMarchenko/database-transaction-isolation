<?php

namespace App\Console\Commands\Simulate\NonRepeatableReads;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateBalanceCommit extends Command
{
    protected $signature = 'non-repeatable-reads:update-balance {isolation=READ COMMITTED}';

    protected $description = 'Command helps to simulate update-balance for non-repeatable reads';

    public function handle()
    {
        sleep(2);
        $isolation = $this->argument('isolation');
        $this->info("---- COMMAND 'Update Balance' is started >>>>");

        DB::statement('SET TRANSACTION ISOLATION LEVEL ' . $isolation);
        $this->info("---- COMMAND 'Update Balance': ISOLATION LEVEL is set to " . $isolation);

        DB::beginTransaction();

        $balance = 1200;
        DB::table('customers')->where('name', 'John Doe')
            ->update(['balance' => $balance]);

        $customer = DB::table('customers')
            ->where('name', 'John Doe')->first();
        $this->info("---- COMMAND 'Update Balance': Balance updated to $customer->balance");

        DB::commit();

        $this->info("---- COMMAND 'Update Balance': Transaction is committed <<<<");
    }
}
