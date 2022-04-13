<?php

namespace App\Console\Commands\Maintenances;

use App\Models\Construction;
use App\Models\Dailyreport;
use Illuminate\Console\Command;

class ConstructionNumberToConstructionIdOnConstructionsTable extends Command
{
    protected $signature = 'constructionNumber_to_construction_id_on_constructions_table:exec';

    public function handle(): void
    {
        $constructions = $this->getConstructions();

        foreach ($constructions as $constructionId => $constructionNumber) {
            $this->updateDailyreportConstructionId($constructionId, $constructionNumber);
        }

        $this->checkSuccess();
    }

    private function getConstructions(): object
    {
        return Construction::pluck('number', 'id')->unique();
    }

    private function updateDailyreportConstructionId($constructionId, $constructionNumber): void
    {
        Dailyreport::where('constructionNumber', $constructionNumber)->update(['construction_id' => $constructionId]);
    }

    private function checkSuccess(): void
    {
        $errorCount = Dailyreport::where('construction_id', 0)->count();
        if (0 === $errorCount) {
            print_r('compleate!');
        } else {
            print_r($errorCount.' faild');
        }
    }
}
