<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\Maintenances\ConstructionNumberToConstructionIdOnConstructionsTable::class,
    ];
}
