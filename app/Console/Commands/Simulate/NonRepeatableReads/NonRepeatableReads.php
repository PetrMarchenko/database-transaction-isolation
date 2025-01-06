<?php

namespace App\Console\Commands\Simulate\NonRepeatableReads;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NonRepeatableReads extends Command
{
    protected $signature = 'simulate:non-repeatable-reads';

    protected $description = 'Simulate command for non-repeatable reads';

    public function handle()
    {
        $filePath = resource_path('info/NonRepeatableReads.md');
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


        $this->info("---Command 'Non repeatable reads' is started---");

        DB::table('customers')->updateOrInsert(
            ['name' => 'John Doe'],
            ['balance' => 1000]
        );
        $this->info('John Doe set balance to 1000');

        exec("php artisan non-repeatable-reads:read-balance \"$isolation\"  > /dev/tty &");
        exec("php artisan non-repeatable-reads:update-balance \"$isolation\"  > /dev/tty &");
    }
}
