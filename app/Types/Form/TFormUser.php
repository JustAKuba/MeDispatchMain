<?php
declare(strict_types=1);

namespace App\Types\Form;

class TFormUser {
    public $id;
    public $email;
    public $password;
    public $role;
    public $created_at;
    public $name;
    public $is_active;
    public $date_deleted;
    public $deleted_by;
}