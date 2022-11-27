<?php
declare(strict_types=1);

namespace App\Model\ProcessManager;

use App\Models\Process\UserProcess;

class UserProcessManager {

	
	public $userProcess;

	public function __construct(UserProcess $userProcess) {
		$this->userProcess = $userProcess;
	}
}