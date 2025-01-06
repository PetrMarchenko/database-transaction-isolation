<?php

namespace App\Console\Commands\Simulate\PhantomReads;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddNewCustomer extends Command
{
    protected $signature = 'phantom-reads:add-new-customer {isolation=READ COMMITTED}';

    protected $description = 'Command helps to simulate add-new-customer for phantom-reads';

    public function handle()
    {

        sleep(2);
        $isolation = $this->argument('isolation');
        $this->info("---- COMMAND 'Add new customers' is started >>>>");
//        DB::statement('SET TRANSACTION ISOLATION LEVEL ' . $isolation);
//        $this->info("---- COMMAND 'Add new customers': ISOLATION LEVEL is set to " . $isolation);

        DB::table('customers')->insert([
            'name' => 'Jane Doe 2',
            'balance' => 900
        ]);
        $this->info("---- COMMAND 'Add new customers': New customer 'Jane Doe 2' added with balance 900");

        $this->info("---- COMMAND 'Add new customers' is completed <<<<");
    }
}
