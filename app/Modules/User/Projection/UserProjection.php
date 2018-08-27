<?php
declare(strict_types=1);

namespace App\Modules\User\Projection;

use App\Modules\User\Event\UserRegisteredEvent;
use App\Modules\User\EventStore\UserEventStore;
use Prooph\EventStore\Projection\ProjectionManager;
use Prooph\EventStore\Projection\ReadModelProjector;

final class UserProjection
{
    /** @var ProjectionManager */
    private $projectionManager;

    /** @var UserReadModel */
    private $userReadModel;

    public function __construct(ProjectionManager $projectionManager, UserReadModel $userReadModel)
    {
        $this->projectionManager = $projectionManager;
        $this->userReadModel = $userReadModel;
    }

    /**
     * @return ReadModelProjector
     */
    public function project(): ReadModelProjector
    {
        $projection = $this->projectionManager->createReadModelProjection(UserReadModel::TABLE, $this->userReadModel);

        $projection->fromStream(UserEventStore::STREAM_USER)
            ->when([
                UserRegisteredEvent::class => function ($state, UserRegisteredEvent $event) {
                    $payload = $event->payload();
                    $this->userReadModel->stack(
                        'insert',
                        [
                            'id' => $event->aggregateId(),
                            'name' => $payload['name'],
                            'email' => $payload['email'],
                        ]
                    );
                },
            ]);

        return $projection;
    }
}
