<?php
declare(strict_types=1);

namespace App\Model\DataSource\Form;

use App\Model\Repository\Table\UserRepository;
use App\Types\DB\Tables\TDBUser;
use App\Types\Form\TFormUser;
use Nette\Security\User;

class UserFormDataSource
{

    public $userRepository;

    public function __construct(UserRepository $userRepository, User $user)
    {
        $this->userRepository = $userRepository;
        $this->user = $user;
    }


    public function getDefaultsEditUser($userId): TFormUser
    {
        $user = $this->userRepository->fetchById($userId);
        $values = new TFormUser();

        if($user){
            $values->id = $user->id;
            $values->name = $user->name;
            $values->email = $user->email;
            $values->role = $user->role;
            $values->created_at = $user->created_at;
            $values->is_active = $user->is_active;
            $values->date_deleted = $user->date_deleted;
            $values->deleted_by = $user->deleted_by;
        } else {
            $values->is_active = 1;
        }
        return $values;
    }

    public function save(TFormUser $values): int {
        $user = new TDBUser();
        $user->id = $values->id;
        $user->name = $values->name;
        $user->email = $values->email;
        $user->role = $values->role;
        $user->password =password_hash($values->password, PASSWORD_DEFAULT);
        return $this->userRepository->save($user);
    }

    public function create(TFormUser $values): int {
            $user = new TDBUser();
            $user->id = $values->id;
            $user->name = $values->name;
            $user->email = $values->email;
            $user->role = $values->role;
            $user->password =password_hash($values->password, PASSWORD_DEFAULT);
            return $this->userRepository->saveWithId($user);
    }
}
