<?php
declare(strict_types=1);

namespace App\Modules\User\Event;

class EmployeeRegisteredHandler
{
    public function __invoke(EmployeeRegisteredEvent $event): void
    {
        // @todo: just a test so nothing yet
        dd('here!!');
        var_dump($event);
    }
}
