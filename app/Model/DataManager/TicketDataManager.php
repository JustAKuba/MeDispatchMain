<?php
declare(strict_types=1);

namespace App\Model\DataManager;

use App\Model\Repository\Table\TicketRepository;
use Nette\Security\User;
class TicketDataManager
{
    public $TicketRepository;

    public $user;

    public function __construct(TicketRepository $TicketRepository, User $user)
    {
        $this->TicketRepository = $TicketRepository;
        $this->user = $user;
    }

    public function delete($id): void
    {
        $this->TicketRepository->softDeleteDate($id, $this->user->getId());
    }
}