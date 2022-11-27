<?php
declare(strict_types=1);

namespace App\Presenters;
use Nette;

final class DashboardPresenter extends BasePresenter
{
    public function renderDefault(): void
    {
        $this->setup();

    }

}
