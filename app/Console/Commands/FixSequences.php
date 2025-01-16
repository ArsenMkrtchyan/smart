<?php

// app/Console/Commands/FixSequences.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixSequences extends Command
{
    protected $signature = 'db:fix-sequences';
    protected $description = 'Adjust sequences to match max(id) in each table';

    public function handle()
    {
        $tables = [
            'patasxanatus',
            'projects',
            // ...
        ];

        foreach ($tables as $table) {
            $sequenceName = $table.'_id_seq'; // как правило, в PG

            // найти max(id)
            $maxId = DB::table($table)->max('id');
            if (is_null($maxId)) {
                $maxId = 0;
            }

            // setval
            $newVal = $maxId + 1;
            $sql = "SELECT setval('{$sequenceName}', {$newVal}, false)";
            DB::statement($sql);

            $this->info("Sequence for {$table} => set to {$newVal}");
        }

        $this->info('Sequences fixed!');
    }
}
