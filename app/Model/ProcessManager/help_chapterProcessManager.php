<?php
declare(strict_types=1);

namespace App\Model\ProcessManager;

use App\Models\Process\help_chapterProcess;

class help_chapterProcessManager
{
    public $help_chapterProcess;

    public function __construct(help_chapterProcessManager $help_chapterProcess) {
        $this->help_chapterProcess = $help_chapterProcess;
    }
}