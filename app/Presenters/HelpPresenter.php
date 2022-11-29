<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

// helpArticle
use App\Model\Repository\Table\help_articleRepository;
use App\Model\DataManager\help_articleDataManager;
use App\Model\DataSource\Form\help_articleFormDataSource;
use App\Types\Form\TFormHelp_article;

// helpChapter
use App\Model\Repository\Table\help_chapterRepository;
use App\Model\DataManager\help_chapterDataManager;
use App\Model\DataSource\Form\help_chapterFormDataSource;
use App\Types\Form\TFormHelp_chapter;


class HelpPresenter extends BasePresenter
{
    // helpArticle
    public $help_articleRepository;
    public $help_articleDataManager;
    public $help_articleFormDataSource;
    public $help_articleForm;
    // helpChapter
    public $help_chapterRepository;
    public $help_chapterDataManager;
    public $help_chapterFormDataSource;
    public $help_chapterForm;


    public function __construct(
        help_articleRepository $help_articleRepository,
        help_articleDataManager $help_articleDataManager,
        help_articleFormDataSource $help_articleFormDataSource,
        TFormHelp_article $help_articleForm,
        help_chapterRepository $help_chapterRepository,
        help_chapterDataManager $help_chapterDataManager,
        help_chapterFormDataSource $help_chapterFormDataSource,
        TFormHelp_chapter $help_chapterForm
    )
    {
        $this->help_articleRepository = $help_articleRepository;
        $this->help_articleDataManager = $help_articleDataManager;
        $this->help_articleFormDataSource = $help_articleFormDataSource;
        $this->help_articleForm = $help_articleForm;
        $this->help_chapterRepository = $help_chapterRepository;
        $this->help_chapterDataManager = $help_chapterDataManager;
        $this->help_chapterFormDataSource = $help_chapterFormDataSource;
        $this->help_chapterForm = $help_chapterForm;
    }


    public function renderDefault(): void
    {
        $this->redirect('Help:Article', 1);
    }

    public  function renderCreateArticle($id) {
        $this->setup('Admin');
        $this->template->help_article = $this->help_articleRepository->findAll();
        $this->template->help_chapter = $this->help_chapterRepository->findAll();

    }

    public function renderEditArticle($id) {
        $this->setup('Admin');
        $this->template->help_article = $this->help_articleRepository->findAll();
        $this->template->help_chapter = $this->help_chapterRepository->findAll();

        $this['formHelp_article']->setDefaults($this->help_articleFormDataSource->getDefaultsEditArticle($id));
    }

    public function actionDeleteArticle($id) {
        $this->help_articleRepository->softDelete($id);
        $this->flashMessage('Article was successfully deleted', 'success');
        $this->redirect('Help:Default');
    }

    public function renderCreateChapter($id) {
        $this->setup('Admin');
        $this->template->help_article = $this->help_articleRepository->findAll();
        $this->template->help_chapter = $this->help_chapterRepository->findAll();
    }

    public function renderEditChapter($id) {
        $this->setup('Admin');
        $this->template->help_article = $this->help_articleRepository->findAll();
        $this->template->help_chapter = $this->help_chapterRepository->findAll();

        $this['formHelp_chapter']->setDefaults($this->help_chapterFormDataSource->getDefaultsEditChapter($id));
    }

    public function actionDeleteChapter($id) {
        $this->help_chapterRepository->softDelete($id);
        $this->flashMessage('Chapter was successfully deleted', 'success');
        $this->redirect('Help:Default');
    }

    public function renderArticle($id)
    {
        $this->setup();
        $this->template->help_article = $this->help_articleRepository->findAll();
        $this->template->help_chapter = $this->help_chapterRepository->findAll();
        $this->template->open_article = $this->help_articleRepository->fetchById($id);
    }

    private function loader() {
        $this->template->help_article = $this->help_articleRepository->findAll();
        $this->template->help_chapter = $this->help_chapterRepository->findAll();
    }



    //Components

    public function createComponentFormHelp_article()
    {
        $form = new Form;
        $form->addHidden('id');
        $form->addText('name', 'Název článku')
            ->setRequired('Prosím zadejte název článku.');
        $form->addSelect('chapter', 'Kategorie', $this->help_chapterRepository->findAllActive()->fetchPairs('id', 'name'))
            ->setRequired('Prosím vyberte kategorii.');
        $form->addTextArea('content', 'Obsah')
            ->setHtmlAttribute('rows', 20)
            ->setHtmlAttribute('cols', 100)
            ->setHtmlAttribute('id', 'tinymceEditor');
        $form->addHidden('author', $this->getUser()->getId());
        $form->addSubmit('send', 'Uložit')
            ->onClick[] = [$this, 'formHelp_articleSucceeded'];
        return $form;
    }

    public function formHelp_articleSucceeded($button)
    {
        $values = $button->getForm()->getValues();
        $this->help_articleRepository->save($values);
        $this->flashMessage('Článek byl úspěšně uložen.', 'success');
        $this->redirect('Help:default');
    }

    public function createComponentFormHelp_chapter()
    {
        $form = new Form;
        $form->addHidden('id');
        $form->addText('name', 'Název kategorie')
            ->setRequired('Prosím zadejte název kategorie.');
        $form->addSubmit('send', 'Uložit')
            ->onClick[] = [$this, 'formHelp_chapterSucceeded'];
        return $form;
    }

    public function formHelp_chapterSucceeded($button)
    {
        $values = $button->getForm()->getValues();
        $this->help_chapterRepository->save($values);
        $this->flashMessage('Kategorie byla úspěšně uložena.', 'success');
        $this->redirect('Help:default');
    }



}