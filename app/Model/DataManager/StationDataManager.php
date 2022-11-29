<?php
declare(strict_types=1);

namespace App\Model\DataManager;

use App\Model\Repository\Table\StationRepository;
use Nette\Security\User;
class StationDataManager
{
    public $StationRepository;

    public $user;

    public function __construct(StationRepository $StationRepository, User $user)
    {
        $this->StationRepository = $StationRepository;
        $this->user = $user;
    }

    public function delete($id): void
    {
        $this->StationRepository->softDeleteDate($id, $this->user->getId());
    }
}