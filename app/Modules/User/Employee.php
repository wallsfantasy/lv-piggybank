<?php
declare(strict_types=1);

namespace App\Modules\User;

use App\Modules\User\Event\EmployeeRegisteredEvent;
use App\Modules\User\Event\UserRegisteredEvent;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;

class Employee extends AggregateRoot
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $email;

    public static function register(string $id, string $name, string $email): self
    {
        $instance = new self();

        $instance->recordThat(EmployeeRegisteredEvent::withData($id, $name, $email));

        return $instance;
    }

    protected function aggregateId(): string
    {
        return $this->id;
    }

    protected function apply(AggregateChanged $e): void
    {
        $handler = 'when' . \implode(\array_slice(\explode('\\', \get_class($e)), -1));

        if (!\method_exists($this, $handler)) {
            throw new \RuntimeException(sprintf(
                'Missing event handler method %s for aggregate root %s',
                $handler,
                \get_class($this)
            ));
        }

        $this->{$handler}($e);
    }

    protected function whenEmployeeRegisteredEvent(EmployeeRegisteredEvent $event): void
    {
        $payload = $event->payload();

        $this->id = $event->aggregateId();
        $this->name = $payload['name'];
        $this->email = $payload['email'];
    }
}
