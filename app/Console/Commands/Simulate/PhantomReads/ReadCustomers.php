<?php

namespace App\Console\Commands\Simulate\PhantomReads;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReadCustomers extends Command
{
    protected $signature = 'phantom-reads:read-customers {isolation=READ COMMITTED}';

    protected $description = 'Command helps to simulate read-customers for phantom-reads';

    public function handle()
    {
        $isolation = $this->argument('isolation');

        $this->info("-- COMMAND 'Read Customers' is started >>");
        DB::statement('SET TRANSACTION ISOLATION LEVEL ' . $isolation);
        $this->info("-- COMMAND 'Read Customers': ISOLATION LEVEL is set to " . $isolation);

        DB::beginTransaction();

        $customers = DB::table('customers')
            ->where('balance', '>', 500)
            ->get();
        $customersCount = count($customers);
        $this->info("-- COMMAND 'Read Customers', Initial customers with balance > 500: $customersCount");


        sleep(5);

        $customers = DB::table('customers')
            ->where('balance', '>', 500)
            ->get();
        $customersCount = count($customers);
        $this->info("-- COMMAND 'Read Customers', Initial customers with balance > 500: $customersCount");

        DB::commit();
        $this->info('-- COMMAND "Read Customers" is completed <<');
    }
}
