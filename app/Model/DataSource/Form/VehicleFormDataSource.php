<?php
declare(strict_types=1);

namespace App\Model\DataSource\Form;

use App\Model\Repository\Table\VehicleRepository;
use App\Types\DB\Tables\TDBVehicle;
use App\Types\Form\TFormVehicle;



class VehicleFormDataSource
{
    public $VehicleRepository;

    public function __construct(VehicleRepository $VehicleRepository, )
    {
        $this->VehicleRepository = $VehicleRepository;
    }

    public function getDefaultsEditVehicle($vehicleId): TFormVehicle
    {
        $vehicle = $this->VehicleRepository->fetchById($vehicleId);
        $values = new TFormVehicle();

        if($vehicle){
            $values->id = $vehicle->id;
            $values->callsign = $vehicle->callsign;
            $values->model = $vehicle->model;
            $values->station = $vehicle->station;
            $values->on_station = $vehicle->on_station;
            $values->created_at = $vehicle->created_at;
            $values->deleted_by = $vehicle->deleted_by;
            $values->date_deleted = $vehicle->date_deleted;
        }
        return $values;
    }

    public function save(TFormVehicle $values): int {
        $vehicle = new TDBVehicle();
        $vehicle->id = $values->id;
        $vehicle->callsign = $values->callsign;
        $vehicle->model = $values->model;
        $vehicle->station = $values->station;
        $vehicle->on_station = $values->on_station;
        $vehicle->created_at = $values->created_at;
        $vehicle->date_deleted = $values->date_deleted;
        $vehicle->deleted_by = $values->deleted_by;
        $vehicle->is_deleted = $values->is_deleted;
        return $this->VehicleRepository->save($vehicle);
    }


}