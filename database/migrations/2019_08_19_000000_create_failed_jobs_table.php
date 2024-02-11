<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailedJobsTable extends \App\Base\Database\MigrationBase
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('failed_jobs', function (\App\Base\Database\BlueprintBase $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection')->nullable();
            $table->text('queue')->nullable();
            $table->longText('payload')->nullable();
            $table->longText('exception')->nullable();
            $table->timestamp('failed_at')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('failed_jobs');
    }
}
