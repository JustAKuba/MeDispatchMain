<?php
declare(strict_types=1);

namespace App\Model\DataManager;

use App\Model\Repository\Table\help_chapterRepository;
use Nette\Security\User;
class help_chapterDataManager
{
    public $help_chapterRepository;

    public $user;

    public function __construct(help_chapterRepository $help_chapterRepository, User $user)
    {
        $this->help_chapterRepository = $help_chapterRepository;
        $this->user = $user;
    }

    public function delete($id): void
    {
        $this->help_chapterRepository->softDeleteDate($id, $this->user->getId());
    }
}