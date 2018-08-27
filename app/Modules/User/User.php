<?php
declare(strict_types=1);

namespace App\Modules\User;

class User
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $email;

    /**
     * @param string $id    Uuid
     * @param string $name  User name
     * @param string $email User email
     *
     * @return User
     */
    public static function register(string $id, string $name, string $email): self
    {
        $self = new self();

        $self->id = $id;
        $self->name = $name;
        $self->email = $email;

        return $self;
    }
}
