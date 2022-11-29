<?php

namespace App\Presenters;

use App\Model\Repository\Table\UserRepository;
use App\Model\DataManager\UserDataManager;
use App\Model\DataSource\Form\UserFormDataSource;
use App\Presenters\BasePresenter;
use App\Types\Form\TFormUser;
use Nette\Application\UI\Form;

class UsersPresenter extends BasePresenter
{
    public $userRepository;
    public $userDataManager;
    public $userFormDataSource;


    public function __construct(UserRepository $userRepository, UserDataManager $userDataManager, UserFormDataSource $userFormDataSource)
    {
        $this->userDataManager = $userDataManager;
        $this->userFormDataSource = $userFormDataSource;
        $this->userRepository = $userRepository;
    }

    public function renderDefault() {
        $this->setup('Admin');
        $this->template->users = $this->userRepository->findAll();
    }

    public function renderCreate(){
        $this->setup('Admin');
    }

    public function renderEdit($id) {
        $this->setup('Admin');
        $this['formUser']->setDefaults($this->userFormDataSource->getDefaultsEditUser($id));
    }

    public function actionDelete($id) {
        $this->setup('Admin');
        $this->userRepository->softDelete($id);
        $this->flashMessage('Uživatel byl odstraněn');
        $this->redirect('Users:default');
    }

    //Components

    public function createComponentFormUser(): Form {
        $form = new Form;
        $form->addHidden('id');
        $form->addText('name', 'Jméno')
            ->setRequired("Zadejte prosím jméno uživatele");
        $form->addText('email', 'Email')
            ->setRequired('Zadejte email uživatele');
        $form->addSelect('role', 'Práva', ['Admin' => 'Admin', 'Dispatch'=>'Dispečer', 'Rescue'=>'Záchranář'])
            ->setRequired('Zadejte prosím práva uživatele');
        $form->addPassword('password', 'Heslo')
            ->setRequired('Zadejte heslo uživatele');
        $form->addSubmit('send','Uložit')
            ->onClick[] = [$this,'FormUserSucceeded'];
        return $form;
    }

    public function FormUserSucceeded(Form $form, $values)
    {
        $tform = new TFormUser();
        $tform->id = $values->id;
        $tform->name = $values->name;
        $tform->email = $values->email;
        $tform->role = $values->role;
        $tform->password = $values->password;
        $this->userFormDataSource->save($tform);
        $this->flashMessage('Uživatel byl uložen','success');
        $this->redirect('Users:default');
    }
}