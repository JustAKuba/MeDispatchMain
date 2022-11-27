<?php
declare(strict_types=1);

namespace App\Presenters;
use Nette;

final class DashboardPresenter extends Nette\Application\UI\Presenter
{
    public function renderDefault(): void
    {
        $this->setup();
    }

    private function setup($access = null)
    {
        // Is user logged in?
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }

        // Is user admin?
        if (isset($access)) {
            if (!$this->getUser()->isInRole($access)) {
                $this->flashMessage('Nemáte dostatečná oprávnění.', 'danger');
                $this->redirect(':Homepage');
            }
        }

        // Set template variables
        /*
        $this->template->pageName = '';
        $this->template->pageNameCs = 'Přehled';
        $this->template->pageModules = [];
        */
        $this->template->user = $this->getUser()->getIdentity();
    }

}
