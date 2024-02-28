<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->id();

            $table->string('party_image')->nullable();
            $table->string('english_party_name')->nullable();
            $table->string('english_party_description')->nullable();
            $table->string('hindi_party_name')->nullable();
            $table->string('hindi_party_description')->nullable();
            $table->string('centre_image_first')->nullable();
            $table->string('centre_image_second')->nullable();
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
        Schema::dropIfExists('parties');
    }
}