<?php
declare(strict_types=1);

namespace App\Modules\User\Event;

class UserRegisteredHandler
{
    public function __invoke(UserRegisteredEvent $event): void
    {
        // @todo: just a test so nothing yet
        var_dump('here!!');
        //var_dump($event);
    }
}
