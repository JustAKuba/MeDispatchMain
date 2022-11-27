<?php
declare(strict_types=1);

namespace App\Model\DataManager;

use App\Model\Repository\Table\UserRepository;
use Nette\Security\User;

class UserDataManager {

    public $userRepository;

    public $user;

    public function __construct(UserRepository $userRepository, User $user)
    {
        $this->userRepository = $userRepository;
        $this->user = $user;
    }

    public function delete($id): void
    {
        $this->userRepository->softDeleteDate($id, $this->user->getId());
    }
}