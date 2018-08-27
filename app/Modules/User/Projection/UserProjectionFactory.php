<?php
declare(strict_types=1);

namespace App\Modules\User\Projection;

use Illuminate\Support\Facades\DB;
use Psr\Container\ContainerInterface;

final class UserProjectionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        DB::connection()->getPdo();
    }
}
