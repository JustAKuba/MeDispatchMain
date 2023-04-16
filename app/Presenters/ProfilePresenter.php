<?php

namespace App\Presenters;

use App\Model\Repository\Table\UserRepository;
use App\Model\DataManager\UserDataManager;
use App\Model\DataSource\Form\UserFormDataSource;
use App\Types\DB\Tables\TDBUser;
use App\Types\Form\TFormUser;

use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

use Nette;

class ProfilePresenter extends BasePresenter
{

    public $userRepository;
    public $userDataManager;
    public $userFormDataSource;


    public function __construct(UserRepository $userRepository, UserDataManager $userDataManager, UserFormDataSource $userFormDataSource)
    {
        $this->userRepository = $userRepository;
        $this->userDataManager = $userDataManager;
        $this->userFormDataSource = $userFormDataSource;
    }

    public function renderDefault() {
        $this->setup();
        $this['formUser']->setDefaults($this->userFormDataSource->getDefaultsEditUser($this->getUser()->id));
    }

    //Components

    public function createComponentFormUser(string $name): Form
    {
        $form = new Form;
        $form->addHidden('id');
        $form->addHidden('role');
        $form->addText('name', 'Jméno')
            ->setRequired('Zadejte prosím jméno');
        $form->addText('email', 'Email')
            ->setRequired('Zadejte prosím email');
        $form->addPassword('password', 'Heslo')
            ->addRule($form::MIN_LENGTH, 'Your password has to be at least %d long', 8);
        $form->addPassword('passwordVerify', 'Opakujte heslo')
            ->addRule($form::EQUAL, 'Hesla nejsou stejná', $form['password']);
        $form->addSubmit('send', 'Uložit')
            ->onClick[] = [$this, 'FormUserSucceeded'];
        return $form;


    }

    public function FormUserSucceeded(Form $form, $values)
    {
        $tform = new TFormUser();
        $tform->id = $values->id;
        $tform->role = $values->role;
        $tform->name = $values->name;
        $tform->email = $values->email;
        $tform->password = $values->password;
        $this->userFormDataSource->save($tform);
        $this->flashMessage('Uživatel byl uložen','success');
        $this->redirect('Dashboard:default');
    }
}