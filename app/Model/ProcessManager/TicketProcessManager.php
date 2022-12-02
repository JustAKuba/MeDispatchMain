<?php
declare(strict_types=1);

namespace App\Model\ProcessManager;

use App\Models\Process\TicketProcess;

class TicketProcessManager
{
    public $ticketProcess;

    public function __construct(TicketProcess $ticketProcess) {
        $this->StationProcess = $ticketProcess;
    }
}