<?php

namespace App\Console\Commands\Simulate\WriteSkew;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TransactionSecond extends Command
{
    protected $signature = 'write-skew:transaction-second {isolation=READ COMMITTED}';

    protected $description = 'Command helps to simulate transaction-second for write-skew.';

    public function handle()
    {
        sleep(1);

        $isolation = $this->argument('isolation');

        $this->info("---- COMMAND 'Transaction Second' is started >>>>");
        DB::statement('SET TRANSACTION ISOLATION LEVEL ' . $isolation);
        $this->info("---- COMMAND 'Transaction Second': ISOLATION LEVEL is set to " . $isolation);

        try {
            DB::beginTransaction();

            $customer = DB::table('customers')->where('name', 'John Doe')->first();
            $this->info("---- COMMAND 'Transaction Second: Balance read as " . $customer->balance);

            $minus = 700;
            if ($customer->balance - $minus < 0) {
                $this->info("---- COMMAND 'Transaction Second: Balance is not enough to deduct $minus");
                DB::rollBack();
                return;
            }

            $this->info("---- COMMAND 'Transaction Second: Sleeping for 5 seconds ...");
            sleep(5);
            $this->info("---- COMMAND 'Transaction Second: Waking up after sleep");

            $balance = $customer->balance - $minus;
            $this->info("---- COMMAND 'Transaction Second: minus = $minus, new balance = $balance");
            DB::table('customers')->where('name', 'John Doe')->update(['balance' => $balance]);
            DB::commit();
            $this->info("---- COMMAND 'Transaction Second' is commited <<<<");
        } catch (\Exception $e) {
            $this->error("---- COMMAND 'Transaction Second': Exception: " . $e->getMessage());
            $this->info("---- COMMAND 'Transaction Second': Rolling back transaction");
            DB::rollBack();
        }


        $customer = DB::table('customers')->where('name', 'John Doe')->first();
        $this->info("---- COMMAND 'Transaction Second: Balance updated to $customer->balance");
    }
}
