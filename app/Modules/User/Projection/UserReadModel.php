<?php
declare(strict_types=1);

namespace App\Modules\User\Projection;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Prooph\EventStore\Projection\AbstractReadModel;

final class UserReadModel extends AbstractReadModel
{
    public const NAME  = 'user';
    public const TABLE = 'users';

    public function init(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('email');

            $table->primary('id');
            // Concurrency check on database level
            $table->unique(['email']);
        });
    }

    public function isInitialized(): bool
    {
        return Schema::hasTable(self::TABLE);
    }

    public function reset(): void
    {
        DB::table(self::TABLE)->truncate();
    }

    public function delete(): void
    {
        Schema::drop(self::TABLE);
    }

    protected function insert(array $data): void
    {
        DB::table(self::TABLE)->insert($data);
    }
}
