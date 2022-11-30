<?php
declare(strict_types=1);

namespace App\Model\DataManager;

use App\Model\Repository\Table\VehicleRepository;
use Nette\Security\User;
class VehicleDataManager
{
    public $VehicleRepository;

    public $user;

    public function __construct(VehicleRepository $VehicleRepository, User $user)
    {
        $this->VehicleRepository = $VehicleRepository;
        $this->user = $user;
    }

    public function delete($id): void
    {
        $this->VehicleRepository->softDeleteDate($id, $this->user->getId());
    }
}