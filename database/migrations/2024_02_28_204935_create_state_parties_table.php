<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatePartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state_parties', function (Blueprint $table) {
            $table->id();

            $table->integer('state_id')->nullable();
            $table->integer('party_id')->nullable();
            $table->string('state_leader_first')->nullable();
            $table->string('state_leader_second')->nullable();
            $table->string('is_deleted')->nullable();

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
        Schema::dropIfExists('state_parties');
    }
}