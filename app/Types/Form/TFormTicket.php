<?php
declare(strict_types=1);

namespace App\Types\Form;

class TFormTicket
{
    public $id;
    public $urgency;
    public $state;
    public $vehicle;
    public $location_address;
    public $location_gps;
    public $summary;
    public $description;
    public $created_at;
    public $date_deleted;
    public $deleted_by;
    public $is_deleted;
}