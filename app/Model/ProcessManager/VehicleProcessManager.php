<?php
declare(strict_types=1);

namespace App\Model\ProcessManager;

use App\Models\Process\VehicleProcess;

class VehicleProcessManager
{
    public $vehicleProcess;

    public function __construct(VehicleProcess $vehicleProcess) {
        $this->StationProcess = $vehicleProcess;
    }
}