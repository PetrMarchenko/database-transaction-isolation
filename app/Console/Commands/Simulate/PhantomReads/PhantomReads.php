<?php

namespace App\Console\Commands\Simulate\PhantomReads;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PhantomReads extends Command
{
    protected $signature = 'simulate:phantom-reads';

    protected $description = 'Simulate Phantom Reads scenario';

    public function handle()
    {
        $filePath = resource_path('info/PhantomReads.md');
        if (file_exists($filePath)) {
            $this->info(file_get_contents($filePath));
        }

        $isolationLevels = [
            'READ UNCOMMITTED',
            'READ COMMITTED',
            'REPEATABLE READ',
            'SERIALIZABLE',
        ];

        $isolation = $this->choice(
            'Select a transaction isolation level:',
            $isolationLevels,
            1
        );

        $this->info("You selected isolation level: $isolation");


        $this->info("---Command 'Phantom Reads Simulation' is started---");

        DB::table('customers')->delete();

        DB::table('customers')->updateOrInsert(
            ['name' => 'John Doe'],
            ['balance' => 1000]
        );

        $customers = DB::table('customers')
            ->where('balance', '>', 500)
            ->get();
        $customersCount = count($customers);
        $this->info("-- COMMAND 'Read Customers', Initial customers with balance > 500: $customersCount");


        exec("php artisan phantom-reads:read-customers \"$isolation\" > /dev/tty &");
        exec("php artisan phantom-reads:add-new-customer \"$isolation\" > /dev/tty &");
    }
}
