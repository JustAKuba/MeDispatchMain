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
    }
}