<?php
declare(strict_types=1);

namespace App\Modules\User\Event;

use Prooph\EventSourcing\AggregateChanged;

class EmployeeRegisteredEvent extends AggregateChanged
{
    public static function withData(string $id, string $name, string $email): self
    {
        return self::occur($id, [
            'name' => $name,
            'email' => $email,
        ]);
    }
}
