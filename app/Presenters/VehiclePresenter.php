<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

use App\Model\DataManager\VehicleDataManager;
use App\Model\Repository\Table\VehicleRepository;
use App\Model\DataSource\Form\VehicleFormDataSource;
use App\Types\DB\Tables\TDBVehicle;
use App\Types\Form\TFormVehicle;

use App\Model\Repository\Table\StationRepository;


class VehiclePresenter extends BasePresenter
{
    public $vehicleRepository;
    public $vehicleDataManager;
    public $vehicleFormDataSource;

    public $stationRepository;

    public function __construct(VehicleRepository $vehicleRepository, VehicleDataManager $vehicleDataManager, VehicleFormDataSource $vehicleFormDataSource, StationRepository $stationRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->vehicleDataManager = $vehicleDataManager;
        $this->vehicleFormDataSource = $vehicleFormDataSource;
        $this->stationRepository = $stationRepository;
    }

    public function renderDefault()
    {
        $this->setup();
        $this->template->vehicles = $this->vehicleRepository->findAll();
        $this->template->stations = $this->stationRepository->findAll()->fetchPairs('id', 'address');
    }

    public function renderCreate()
    {
        $this->setup();
    }

    public function renderEdit($id)
    {
        $this->setup();
        $this['formVehicle']->setDefaults($this->vehicleFormDataSource->getDefaultsEditVehicle($id));
    }

    public function actionDelete($id)
    {
        $this->setup();
        $this->vehicleRepository->softDelete($id);
        $this->flashMessage('Vozidlo bylo odstraněno');
        $this->redirect('Vehicle:default');
    }

    //Components

    public function createComponentFormVehicle(): Form
    {
        $form = new Form;
        $form->addHidden('id');
        $form->addText('callsign', 'Označení')
            ->setRequired("Zadejte prosím název vozidla");
        $form->addText('model', 'Model')
            ->setRequired('Zadejte prosím typ vozidla');
        $form->addSelect('station', 'Základna', $this->stationRepository->findAllActive()->fetchPairs('id', 'address'))
            ->setRequired('Zadejte prosím číslo vozidla');
        $form->addSubmit('send', 'Uložit');
        $form->onSuccess[] = [$this, 'formVehicleSucceeded'];
        return $form;
    }

    public function formVehicleSucceeded(Form $form, $values)
    {
        $this->setup();
        $this->vehicleRepository->save($values);
        $this->flashMessage('Vozidlo bylo uloženo');
        $this->redirect('Vehicle:default');
    }



}