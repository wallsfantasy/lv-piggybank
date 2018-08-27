<?php
declare(strict_types=1);

namespace App\Modules\User\EventStore;

use Prooph\EventSourcing\Aggregate\AggregateRepository;

class UserEventStore extends AggregateRepository
{
    public const STREAM_USER = 'user_stream';
}
