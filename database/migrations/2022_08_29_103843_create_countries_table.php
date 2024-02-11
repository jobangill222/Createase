<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends \App\Base\Database\MigrationBase
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('countries', function (\App\Base\Database\BlueprintBase $table) {
            $table->id();
            $table->string('name')->unique()->nullable();
            $table->string('iso')->unique()->nullable();
            $table->string('iso3')->unique()->nullable();
            $table->string('num_code')->nullable();
            $table->string('phone_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
