<?php

namespace App\Presenters;

use App\Model\Repository\Table\StationRepository;
use App\Model\DataManager\StationDataManager;
use App\Model\DataSource\Form\StationFormDataSource;
use App\Types\DB\Tables\TDBStation;
use App\Types\Form\TFormStation;
use Nette\Application\UI\Form;


class StationPresenter extends BasePresenter
{
    public $stationRepository;
    public $stationDataManager;
    public $stationFormDataSource;

    public function __construct(StationRepository $stationRepository, StationDataManager $stationDataManager, StationFormDataSource $stationFormDataSource)
    {
        $this->stationRepository = $stationRepository;
        $this->stationDataManager = $stationDataManager;
        $this->stationFormDataSource = $stationFormDataSource;
    }

    public function renderDefault()
    {
        $this->setup();
        $this->template->stations = $this->stationRepository->findAll();
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