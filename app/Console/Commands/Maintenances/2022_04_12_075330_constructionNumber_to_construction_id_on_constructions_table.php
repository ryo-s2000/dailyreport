<?php

namespace App\Console\Commands\Maintenances;

use Illuminate\Console\Command;

class ConstructionNumberToConstructionIdOnConstructionsTable extends Command
{
    protected $signature = 'constructionNumber_to_construction_id_on_constructions_table:exec';

    public function handle(): void
    {
        echo 'run constructionNumber_to_construction_id_on_constructions_table:exec';
    }
}
