<?php
declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Modules\User\Command\RegisterUserCommand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Prooph\Common\Messaging\FQCNMessageFactory;
use Prooph\ServiceBus\CommandBus;

final class RegisterUserHttp extends Controller
{
    /** @var FQCNMessageFactory */
    private $messageFactory;

    /** @var CommandBus */
    private $commandBus;

    public function __construct(FQCNMessageFactory $messageFactory, CommandBus $commandBus)
    {
        $this->messageFactory = $messageFactory;
        $this->commandBus = $commandBus;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  Request $request
     */
    public function __invoke(Request $request): void
    {
        $payload = \json_decode($request->getContent(), true);

        $command = $this->messageFactory->createMessageFromArray(
            RegisterUserCommand::class,
            [
                'message_name' => RegisterUserCommand::NAME,
                'uuid' => null, // handle by factory
                'created_at' => \DateTimeImmutable::createFromMutable(Carbon::now()),
                'metadata' => null, // add nothing yet,
                'payload' => $payload,
            ]
        );

        $this->commandBus->dispatch($command);
    }
}
