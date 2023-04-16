<?php

namespace App\Presenters;

use App\Model\DataManager\StationDataManager;
use App\Model\DataManager\TicketDataManager;
use App\Model\DataManager\VehicleDataManager;
use App\Model\DataSource\Form\StationFormDataSource;
use App\Model\DataSource\Form\TicketFormDataSource;
use App\Model\DataSource\Form\VehicleFormDataSource;
use App\Model\Repository\Table\StationRepository;
use App\Model\Repository\Table\TicketRepository;
use App\Model\Repository\Table\VehicleRepository;

class ApiPresenter extends BasePresenter
{
    public $TicketFormDataSource;
    public $TicketDataManager;
    public $TicketRepository;

    public $VehicleFormDataSource;
    public $VehicleDataManager;
    public $VehicleRepository;

    public $StationFormDataSource;
    public $StationDataManager;
    public $StationRepository;


    public function __construct( TicketFormDataSource $TicketFormDataSource, TicketDataManager $TicketDataManager, TicketRepository $TicketRepository, VehicleFormDataSource $VehicleFormDataSource, VehicleDataManager $VehicleDataManager, VehicleRepository $VehicleRepository, StationFormDataSource $StationFormDataSource, StationDataManager $StationDataManager, StationRepository $StationRepository)
    {
        $this->TicketFormDataSource = $TicketFormDataSource;
        $this->TicketDataManager = $TicketDataManager;
        $this->TicketRepository = $TicketRepository;

        $this->VehicleFormDataSource = $VehicleFormDataSource;
        $this->VehicleDataManager = $VehicleDataManager;
        $this->VehicleRepository = $VehicleRepository;

        $this->StationFormDataSource = $StationFormDataSource;
        $this->StationDataManager = $StationDataManager;
        $this->StationRepository = $StationRepository;
    }

    function renderDefault() {

    }

    function actionGetTicket($id)
    {
        $this->sendJson($this->TicketRepository->findAllActive()->where($id));
    }

    function actionGetTickets()
    {
        $this->sendJson($this->TicketRepository->findAllActive());
    }

    function actionChangeTicketState($id, $state)
    {
        $values = [
            'id' => $id,
            'state' => $state
        ];
        $this->TicketRepository->save($values);
    }
    //TODO: Add Api methods
}