<?php
declare(strict_types=1);

namespace App\Model\DataSource\Form;

use App\Model\Repository\Table\help_chapterRepository;
use App\Types\DB\Tables\TDBHelp_chapter;
use App\Types\Form\TFormHelp_chapter;



class help_chapterFormDataSource
{
    public $help_chapterRepository;

    public function __construct(help_chapterRepository $help_chapterRepository, )
    {
        $this->help_chapterRepository = $help_chapterRepository;
    }

    public function save(TFormHelp_chapter $values): int {
        $help_chapter = new TDBHelp_chapter();
        $help_chapter->id = $values->id;
        $help_chapter->name = $values->name;
        $help_chapter->tech_name = $values->tech_name;
        $help_chapter->created_at = $values->created_at;
        $help_chapter->date_deleted = $values->date_deleted;
        $help_chapter->deleted_by = $values->deleted_by;
        return $this->help_chapterRepository->save($help_chapter);
    }


}