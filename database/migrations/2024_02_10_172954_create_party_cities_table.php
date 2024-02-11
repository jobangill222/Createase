<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartyCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('party_cities', function (Blueprint $table) {
            $table->id();

            $table->string('english_name')->nullable();
            $table->string('hindi_name')->nullable();
            $table->integer('party_state_id')->nullable();
            // $table->foreignId('party_state_id')->nullable()->references('id')->on('party_states')->nullOnDelete();



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
        Schema::dropIfExists('party_cities');
    }
}
