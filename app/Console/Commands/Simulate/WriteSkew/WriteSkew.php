<?php

namespace App\Console\Commands\Simulate\WriteSkew;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class WriteSkew extends Command
{
    protected $signature = 'simulate:write-skew';

    protected $description = 'Simulate command for write skew';

    public function handle()
    {
        $filePath = resource_path('info/WriteSkew.md');
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


        $this->info("---Command 'Write Skew' is started---");

        DB::table('customers')->updateOrInsert(
            ['name' => 'John Doe'],
            ['balance' => 1000]
        );
        $this->info('John Doe set balance to 1000');

        exec("php artisan write-skew:transaction-first \"$isolation\" > /dev/tty &");
        exec("php artisan write-skew:transaction-second \"$isolation\" > /dev/tty &");
    }
}
