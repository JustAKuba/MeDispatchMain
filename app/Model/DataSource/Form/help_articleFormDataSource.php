<?php
declare(strict_types=1);

namespace App\Model\DataSource\Form;

use App\Model\Repository\Table\help_articleRepository;
use App\Types\DB\Tables\TDBHelp_article;
use App\Types\Form\TFormHelp_article;



class help_articleFormDataSource
{
    public $help_articleRepository;

    public function __construct(help_articleRepository $help_articleRepository, )
    {
        $this->help_articleRepository = $help_articleRepository;
    }

    public function getDefaultsEditArticle($articleId): TFormHelp_article
    {
        $article = $this->help_articleRepository->fetchById($articleId);
        $values = new TFormHelp_article();

        if($article){
            $values->id = $article->id;
            $values->chapter = $article->chapter;
            $values->name = $article->name;
            $values->content = $article->content;
            $values->created_at = $article->created_at;
            $values->author = $article->author;
            $values->deleted_by = $article->deleted_by;
            $values->date_deleted = $article->date_deleted;
        }
        return $values;
    }

    public function save(TFormHelp_article $values): int {
        $help_article = new TDBHelp_article();
        $help_article->id = $values->id;
        $help_article->name = $values->name;
        $help_article->tech_name = $values->tech_name;
        $help_article->content = $values->content;
        $help_article->created_at = $values->created_at;
        $help_article->date_deleted = $values->date_deleted;
        $help_article->author = $values->author;
        $help_article->chapter = $values->chapter;
        $help_article->deleted_by = $values->deleted_by;
        return $this->help_articleRepository->save($help_article);
    }


}