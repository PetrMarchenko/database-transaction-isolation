<?php

namespace App\Console\Commands\Simulate\DirtyReads;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DirtyReads extends Command
{
    protected $signature = 'simulate:dirty-reads';

    protected $description = 'Simulate command for dirty reads';

    public function handle()
    {
        $filePath = resource_path('info/DirtyReads.md');
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


        $this->info("---Command 'Dirty Reads' is started---");

        DB::table('customers')->updateOrInsert(
            ['name' => 'John Doe'],
            ['balance' => 1000]
        );
        $this->info('John Doe set balance to 1000');

        exec("php artisan dirty-reads:update-balance-rollback \"$isolation\"  > /dev/tty &");
        exec("php artisan dirty-reads:read-balance \"$isolation\" > /dev/tty &");
    }
}
