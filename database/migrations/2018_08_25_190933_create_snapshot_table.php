<?php

use Illuminate\Database\Migrations\Migration;
use Prooph\Package\Migration\Schema\SnapshotSchema;

class CreateSnapshotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        SnapshotSchema::create('snapshot');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        SnapshotSchema::drop('snapshot');
    }
}
