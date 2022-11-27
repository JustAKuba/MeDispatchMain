<?php
declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Security\SimpleIdentity;

class UserAuthenticator implements Nette\Security\Authenticator
{
    private $database;
    private $passwords;

    public function __construct(
        Nette\Database\Explorer $database,
        Nette\Security\Passwords $passwords
    ) {
        $this->database = $database;
        $this->passwords = $passwords;
    }

    public function authenticate(string $email, string $password): SimpleIdentity
    {
        $row = $this->database->table('user')
            ->where('email', $email)
            ->fetch();

        if (!$row) {
            throw new Nette\Security\AuthenticationException('Takový uživatel neexistuje.');
        }

        if (!$this->passwords->verify($password, $row->password)) {
            throw new Nette\Security\AuthenticationException('Neplatné heslo.');
        }

        return new SimpleIdentity($row->id, ['permission' => $row->role], ['name' => $row->name, 'email' => $row->email]);
    }

    public function changePassword(string $email, string $password, string $newPassword): void
    {
        $row = $this->database->table('user')
            ->where('email', $email)
            ->fetch();

        if (!$row) {
            throw new Nette\Security\AuthenticationException('Takový uživatel neexistuje.');
        }

        if (!$this->passwords->verify($password, $row->password)) {
            throw new Nette\Security\AuthenticationException('Neplatné heslo.');
        }

        $this->database->table('user')
            ->where('email', $email)
            ->update([
                'password' => $this->passwords->hash($newPassword),
            ]);
    }

    public function updateValue($identity, string $valueId, $value)
    {
        $this->database->table('user')
            ->where('id', $identity->getId())
            ->update([
                $valueId => $value,
            ]);
        $identity->__set($valueId, $value);
    }
}