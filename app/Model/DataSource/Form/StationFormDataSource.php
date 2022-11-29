<?php
declare(strict_types=1);

namespace App\Model\DataSource\Form;

use App\Model\Repository\Table\StationRepository;
use App\Types\DB\Tables\TDBStation;
use App\Types\Form\TFormStation;



class StationFormDataSource
{
    public $StationRepository;

    public function __construct(StationRepository $StationRepository, )
    {
        $this->StationRepository = $StationRepository;
    }

    public function getDefaultsEditStation($stationId): TFormStation
    {
        $station = $this->StationRepository->fetchById($stationId);
        $values = new TFormStation();

        if($station){
            $values->id = $station->id;
            $values->name = $station->name;
            $values->address = $station->address;
            $values->phone = $station->phone;
            $values->size = $station->size;
            $values->created_at = $station->created_at;
            $values->deleted_by = $station->deleted_by;
            $values->date_deleted = $station->date_deleted;
        }
        return $values;
    }

    public function save(TFormStation $values): int {
        $station = new TDBStation();
        $station->id = $values->id;
        $station->name = $values->name;
        $station->address = $values->address;
        $station->size = $values->size;
        $station->phone = $values->phone;
        $station->created_at = $values->created_at;
        $station->date_deleted = $values->date_deleted;
        $station->deleted_by = $values->deleted_by;
        $station->is_deleted = $values->is_deleted;
        return $this->StationRepository->save($station);
    }


}