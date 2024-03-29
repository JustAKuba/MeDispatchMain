<?php

namespace App\Presenters;

abstract class BasePresenter extends \Nette\Application\UI\Presenter
{
    public function setup($access = null)
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

        $this->template->user = $this->getUser()->getIdentity();
        $this->template->userRole = $this->getUser()->getRoles()['permission'];
        $this->template->pageLink = $this->link('//this');
    }

    public function setupPublic() {
        $this->template->user = $this->getUser()->getIdentity();
        try{
            $this->template->userRole = $this->getUser()->getRoles()['permission'];
        } catch (\Exception $e) {
            $this->template->userRole = null;
        }
        $this->template->pageLink = $this->link('//this');
    }
}