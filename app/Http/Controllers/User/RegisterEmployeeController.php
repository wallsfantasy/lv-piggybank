<?php
declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Modules\User\Command\RegisterEmployeeCommand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Prooph\Common\Messaging\FQCNMessageFactory;
use Prooph\EventStore\Exception\ConcurrencyException;
use Prooph\ServiceBus\CommandBus;

final class RegisterEmployeeController extends Controller
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
     * Create a new employee instance after a valid registration.
     *
     * @param  Request $request
     */
    public function __invoke(Request $request): void
    {
        $payload = \json_decode($request->getContent(), true);

        $command = $this->messageFactory->createMessageFromArray(
            RegisterEmployeeCommand::class,
            [
                'message_name' => RegisterEmployeeCommand::NAME,
                'uuid' => null, // handle by factory
                'created_at' => \DateTimeImmutable::createFromMutable(Carbon::now()),
                'metadata' => null, // add nothing yet,
                'payload' => $payload,
            ]
        );

        try {
            $this->commandBus->dispatch($command);
        } catch (\Throwable $e) {
            // @todo: handle exception in App\Exceptions\Handler
            dump(get_class($e));
            dump(get_class($e->getPrevious()));
            /** @var ConcurrencyException $prev */
            dd($prev = $e->getPrevious()->getMessage());
        }
    }
}
