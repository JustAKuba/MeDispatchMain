<?php

namespace App\Presenters;


use App\Model\Repository\Table\TicketRepository;
use App\Model\DataSource\Form\TicketFormDataSource;
use App\Model\DataManager\TicketDataManager;

use App\Model\Repository\Table\VehicleRepository;
use App\Model\DataSource\Form\VehicleFormDataSource;
use App\Model\DataManager\VehicleDataManager;

use App\Model\Repository\Table\StationRepository;
use App\Model\DataSource\Form\StationFormDataSource;
use App\Model\DataManager\StationDataManager;

use App\Types\Form\TFormTicket;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\InvalidArgumentException;

class TicketPresenter extends BasePresenter
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

    public function renderDefault(): void
    {
        $this->setup();
        //TODO: sort by date, add pagination
        $this->template->tickets = $this->TicketRepository->findAllActive();
        $this->template->vehicles = $this->VehicleRepository->findAll()->fetchPairs('id', 'callsign');
        $this->template->stations = $this->StationRepository->findAll();
    }

    public function renderCreate(): void
    {
        $this->setup();
        //$this['formTicket']->addSelect('vehicle', 'Vozidlo', $this->VehicleRepository->findAll()->where('on_station = 1')->fetchPairs('id', 'callsign'))
        //    ->setRequired('Vyberte prosím vozidlo');
    }

    public function renderEdit($id): void
    {
        $this->setup();


        $this['formTicket']->setDefaults($this->TicketFormDataSource->getDefaultsEditTicket($id));

    }

    public function renderView($id): void
    {
        $this->setup();
        $this->template->ticket = $this->TicketRepository->find($id);
        $this->template->vehicle = $this->VehicleRepository->find($this->template->ticket->vehicle);
        $this->template->station = $this->StationRepository->find($this->template->vehicle->station);
    }

    public function actionDelete($id): void
    {
        $this->setup();
        $this->TicketRepository->softDelete($id);
        $this->flashMessage('Požadavek byl odstraněn');
        $this->redirect('Ticket:default');
    }

    //Components

    public function createComponentFormTicket(): Form
    {
        $vehid = "";
        $form = new Form;
        $form->addHidden('id');
        $form->addText('location_address', 'Adresa');
        $form->addText('location_gps', 'GPS');
        $form->addSelect('urgency', 'Naléhavost', [0=>'Velmi závažné', 1=>'Závažné', 2=>'Normální', 3=>'Nízká priorita'])
          ->setRequired('Nastavte prosím naléhavost');
        $form->addSelect('vehicle', 'Vozidlo', $this->VehicleRepository->findAllActive()->fetchPairs('id','callsign'))
            ->setRequired('Vyberte prosím vozidlo');
        $form->addText('summary', 'Stručný popis')
            ->setRequired('Prosím vyplňte stručný popis');
        $form->addTextArea('description', 'Celkový popis')
            ->setHtmlAttribute('id', 'tinymceEditor');
        $form->addSelect('state', 'Stav', [0=>'Na cestě',1=>'Na místě',2=>'Cesta do N', 3=>'Vyřešeno', 4=>'Zrušeno', 5=>'Nový'])
            ->setDefaultValue(5)
            ->setRequired('Nastavte prosím stav');
        $form->addSubmit('submit', 'Uložit')
            ->setHtmlAttribute('class', 'btn btn-primary');
        $form->onSuccess[] = [$this, 'formTicketSucceeded'];

        return $form;
    }

    public function formTicketSucceeded(Form $form, $values): void
    {
        $this->setup();
        $this->TicketRepository->save($values);
        if($values->state <= 2) {
            $this->VehicleRepository->save(['id' => $values->vehicle,'on_station' => 0]);
        } else {
            $this->VehicleRepository->save(['id' => $values->vehicle,'on_station' => 1]);
        }
        $this->flashMessage('Požadavek byl uložen');
        $this->redirect('Ticket:default');
    }

}
