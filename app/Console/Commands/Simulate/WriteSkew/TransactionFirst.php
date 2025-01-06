<?php

namespace App\Console\Commands\Simulate\WriteSkew;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TransactionFirst extends Command
{
    protected $signature = 'write-skew:transaction-first {isolation=READ COMMITTED}';

    protected $description = 'Command helps to simulate transaction-first for write-skew.';

    public function handle()
    {
        $isolation = $this->argument('isolation');

        $this->info("-- COMMAND 'Transaction First' is started >>");
        DB::statement('SET TRANSACTION ISOLATION LEVEL ' . $isolation);
        $this->info("-- COMMAND 'Transaction First': ISOLATION LEVEL is set to " . $isolation);

        DB::beginTransaction();

        $customer = DB::table('customers')->where('name', 'John Doe')->first();
        $this->info("-- COMMAND 'Transaction First': Balance read as " . $customer->balance);

        $minus = 600;
        if ($customer->balance - $minus < 0) {
            $this->info("-- COMMAND 'Transaction First': Balance is not enough to deduct $minus");
            DB::rollBack();
            return;
        }

        sleep(2);

        $balance = $customer->balance - $minus;
        $this->info("-- COMMAND 'Transaction First': minus = $minus, new balance = $balance");
        DB::table('customers')->where('name', 'John Doe')->update(['balance' => $balance]);

        DB::commit();
        $this->info("-- COMMAND 'Transaction First' is commited <<");

        $customer = DB::table('customers')->where('name', 'John Doe')->first();
        $this->info("-- COMMAND 'Transaction First': Balance updated to $customer->balance");
    }
}
