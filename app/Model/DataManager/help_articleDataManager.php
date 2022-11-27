<?php
declare(strict_types=1);

namespace App\Model\DataManager;

use App\Model\Repository\Table\help_articleRepository;
use Nette\Security\User;
class help_articleDataManager
{
    public $help_articleRepository;

    public $user;

    public function __construct(help_articleRepository $help_articleRepository, User $user)
    {
        $this->help_articleRepository = $help_articleRepository;
        $this->user = $user;
    }

    public function delete($id): void
    {
        $this->help_articleRepository->softDeleteDate($id, $this->user->getId());
    }
}