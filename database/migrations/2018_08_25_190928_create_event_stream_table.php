<?php

use Illuminate\Database\Migrations\Migration;
use Prooph\Package\Migration\Schema\EventStoreSchema;

class CreateEventStreamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        EventStoreSchema::createSingleStream('event_stream', true);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        EventStoreSchema::dropStream('event_stream');
    }
}
