<?php
declare(strict_types=1);

namespace App\Model\ProcessManager;

use App\Models\Process\help_articleProcess;

class help_articleProcessManager
{
    public $help_articleProcess;

    public function __construct(help_articleProcess $help_articleProcess) {
        $this->help_articleProcess = $help_articleProcess;
    }
}