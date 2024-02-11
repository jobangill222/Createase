<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends \App\Base\Database\MigrationBase
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('users', function (\App\Base\Database\BlueprintBase $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();

            $table->timestamp('email_verified_at')->nullable();

            $table->string('phone_number')->nullable();
            $table->timestamp('phone_number_verified_at')->nullable();

            $table->string('password')->nullable();
            $table->rememberToken()->nullable();

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
        Schema::dropIfExists('users');
    }
}
