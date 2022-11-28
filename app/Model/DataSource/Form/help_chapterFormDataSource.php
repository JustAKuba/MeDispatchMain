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

    public function getDefaultsEditChapter($chapterId): TFormHelp_chapter
    {
        $chapter = $this->help_chapterRepository->fetchById($chapterId);
        $values = new TFormHelp_chapter();

        if($chapter){
            $values->id = $chapter->id;
            $values->name = $chapter->name;
            $values->created_at = $chapter->created_at;
            $values->deleted_by = $chapter->deleted_by;
            $values->date_deleted = $chapter->date_deleted;
        }
        return $values;
    }

    public function save(TFormHelp_chapter $values): int {
        $help_chapter = new TDBHelp_chapter();
        $help_chapter->id = $values->id;
        $help_chapter->name = $values->name;
        $help_chapter->tech_name = $values->tech_name;
        $help_chapter->created_at = $values->created_at;
        $help_chapter->date_deleted = $values->date_deleted;
        $help_chapter->deleted_by = $values->deleted_by;
        $help_chapter->is_deleted = $values->is_deleted;
        return $this->help_chapterRepository->save($help_chapter);
    }


}