<?php
declare(strict_types=1);

namespace App\Modules\User\Command;

use App\Modules\User\Employee;
use App\Modules\User\EventStore\EmployeeEventStore;

class RegisterEmployeeHandler
{
    /** @var Employee */
    private $employeeEventStore;

    public function __construct(EmployeeEventStore $employeeEventStore)
    {
        $this->employeeEventStore = $employeeEventStore;
    }

    public function __invoke(RegisterEmployeeCommand $command): void
    {
        $payload = $command->payload();

        $employee = Employee::register($payload['id'], $payload['name'], $payload['email']);

        $this->employeeEventStore->saveAggregateRoot($employee);
    }
}
