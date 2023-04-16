<?php

namespace App\Presenters;

use App\Model\Repository\Table\VehicleRepository;
use App\Model\DataManager\VehicleDataManager;
use App\Model\DataSource\Form\VehicleFormDataSource;
use App\Types\DB\Tables\TDBVehicle;
use App\Types\Form\TFormVehicle;


use App\Model\Repository\Table\StationRepository;
use App\Model\DataManager\StationDataManager;
use App\Model\DataSource\Form\StationFormDataSource;
use App\Types\DB\Tables\TDBStation;
use App\Types\Form\TFormStation;

use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;


class StationPresenter extends BasePresenter
{
    public $stationRepository;
    public $stationDataManager;
    public $stationFormDataSource;

    public $vehicleRepository;
    public $vehicleDataManager;
    public $vehicleFormDataSource;


    public function __construct(StationRepository $stationRepository, StationDataManager $stationDataManager, StationFormDataSource $stationFormDataSource, VehicleRepository $vehicleRepository, VehicleDataManager $vehicleDataManager, VehicleFormDataSource $vehicleFormDataSource)
    {
        $this->stationRepository = $stationRepository;
        $this->stationDataManager = $stationDataManager;
        $this->stationFormDataSource = $stationFormDataSource;

        $this->vehicleRepository = $vehicleRepository;
        $this->vehicleDataManager = $vehicleDataManager;
        $this->vehicleFormDataSource = $vehicleFormDataSource;

    }

    public function renderDefault()
    {
        $this->setup();



        $readyStations = [];

        //Add data about stations into readyStations with number of vehicles data
        foreach ($this->stationRepository->findAllActive() as $station) {
            $newStation = new ArrayHash();
            $newStation->id = $station->id;
            $newStation->name = $station->name;
            $newStation->address = $station->address;
            $newStation->size = $station->size;
            $newStation->vehicleCount = $this->vehicleRepository->findAllActive()->where('station', $station->id)->count();
            $newStation->onStationVehicleCount = $this->vehicleRepository->findAllActive()->where('station', $station->id)->where('on_station', 1)->count();

            //Add newStation into readyStations
            $readyStations[$newStation->id] = $newStation;
        }

        $this->template->stations = $readyStations;

    }

    public function renderCreate()
    {
        $this->setup();
    }

    public function renderEdit($id)
    {
        $this->setup();
        $this['formStation']->setDefaults($this->stationFormDataSource->getDefaultsEditStation($id));
    }

    public function actionDelete($id)
    {
        $this->setup();
        $this->stationRepository->softDelete($id);
        $this->flashMessage('Základna byla odstraněna');
        $this->redirect('Station:default');
    }

    //Components

    public function createComponentFormStation(): Form
    {
        $form = new Form;
        $form->addHidden('id');
        $form->addText('name', 'Název')
            ->setRequired("Zadejte prosím název základny");
        $form->addText('address', 'Adresa')
            ->setRequired('Zadejte prosím adresu základny');
        $form->addText('phone', 'Telefon')
            ->setRequired('Zadejte prosím telefon základny');
        $form->addText('size', 'Počet vozidel')
            ->setRequired('Zadejte prosím velikost základny');
        $form->addSubmit('send','Uložit')
            ->onClick[] = [$this, 'formStationSucceeded'];
        return $form;
    }

    public function formStationSucceeded($button)
    {
        $values = $button->getForm()->getValues();
        $this->stationRepository->save($values);
        $this->flashMessage('Základna byla uložena');
        $this->redirect('Station:default');
    }
}