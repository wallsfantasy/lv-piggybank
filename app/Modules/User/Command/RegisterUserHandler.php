<?php
declare(strict_types=1);

namespace App\Modules\User\Command;

use App\Modules\User\EventStore\UserEventStore;
use App\Modules\User\User;

class RegisterUserHandler
{
    /** @var User */
    private $userEventStore;

    public function __construct(UserEventStore $userEventStore)
    {
        $this->userEventStore = $userEventStore;
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        $payload = $command->payload();

        $user = User::register($payload['id'], $payload['name'], $payload['email']);

        $this->userEventStore->saveAggregateRoot($user);
    }
}
