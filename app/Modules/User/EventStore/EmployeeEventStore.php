<?php
declare(strict_types=1);

namespace App\Modules\User\EventStore;

use Prooph\EventSourcing\Aggregate\AggregateRepository;

class EmployeeEventStore extends AggregateRepository
{
    public const STORE = 'employee_store';
    public const STREAM_EMPLOYEE = 'employee_stream';
}
