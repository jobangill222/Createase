<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRolesTable extends \App\Base\Database\MigrationBase
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('user_roles', function (\App\Base\Database\BlueprintBase $table) {
            $table->id();
            $table->string('name')->unique()->nullable();
        });

        \App\Models\UserRole::upsert([['name' => 'Admin'], ['name' => 'User']], ['name']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
}
