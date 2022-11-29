<?php
declare(strict_types=1);

namespace App\Model\ProcessManager;

use App\Models\Process\StationProcess;

class StationProcessManager
{
    public $StationProcess;

    public function __construct(StationProcess $StationProcess) {
        $this->StationProcess = $StationProcess;
    }
}