<?php
declare(strict_types=1);

namespace App\Modules\User\Command;

use App\Modules\User\User;

class RegisterUserHandler
{
    public function __invoke(RegisterUserCommand $command): void
    {
        $payload = $command->payload();

        $user = User::register($payload['id'], $payload['name'], $payload['email']);

        // just check command works
        //var_dump($user);exit();
    }
}
