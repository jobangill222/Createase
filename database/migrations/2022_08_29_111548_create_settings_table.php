<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends \App\Base\Database\MigrationBase
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('settings', function (\App\Base\Database\BlueprintBase $table) {
            $table->id();
            $table->string('name')->unique();
            $table->longText('value')->nullable();
            $table->string('type')->default('input');
            $table->ipAddresses(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
