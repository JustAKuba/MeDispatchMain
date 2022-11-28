<?php
declare(strict_types=1);

namespace App\Presenters;
use Nette;
use Nette\Application\UI\Form;
Use App\Model\UserAuthenticator;



final class SignPresenter extends Nette\Application\UI\Presenter
{
    private $authenticator;

    public function __construct(UserAuthenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function renderDefault() {
        if($this->getUser()->isLoggedIn()) {
            $this->redirect('Dashboard:default');
        }
}


    protected function createComponentSignInForm(): Form
    {
        $form = new Form;
        $form->addText('email', 'Email:')
            ->setRequired('Prosím zadejte email.');

        $form->addPassword('password', 'Heslo:')
            ->setRequired('Prosím zadejte heslo.');

        $form->addSubmit('send', 'Přihlásit se');

        $form->onSuccess[] = [$this, 'signInFormSucceeded'];
        return $form;
    }

    public function signInFormSucceeded(Form $form, \stdClass $data): void
    {
        try {
            $this->getUser()->setAuthenticator($this->authenticator)
                ->login($data->email, $data->password);
            $this->redirect('Dashboard:default');
        } catch (Nette\Security\AuthenticationException $e) {
            $this->flashMessage($e->getMessage(), 'danger');
        }
    }

    public function actionOut(): void
    {
        $this->getUser()->logout();
        $this->redirect(':Sign:in');
    }
}