<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends \App\Base\Database\MigrationBase
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->table('users', function (\App\Base\Database\BlueprintBase $table) {
            $table->string('username')->unique()->after('name')->nullable();
            // $table->foreignId('country_id')->default(\App\Constants\CommonConstants::DEFAULT_COUNTRY)->after('password')->references('id')->on('countries')->onDelete('cascade');
            // $table->foreignId('state_id')->default(\App\Constants\CommonConstants::DEFAULT_STATE)->after('country_id')->references('id')->on('states')->onDelete('cascade');
            // $table->foreignId('city_id')->default(\App\Constants\CommonConstants::DEFAULT_CITY)->after('state_id')->references('id')->on('cities')->onDelete('cascade');
            $table->string('country_id')->after('password')->nullable();
            $table->string('state_id')->after('country_id')->nullable();
            $table->string('city_id')->after('state_id')->nullable();

            $table->foreignId('user_role_id')->default(\App\Constants\CommonConstants::DEFAULT_USER_ROLE)->after('city_id')->references('id')->on('user_roles')->onDelete('cascade');
            $table->string('status')->default(\App\Constants\UserConstants::STATUS_ACTIVE)->after('user_role_id');
            $table->string('profile_pic')->nullable()->after('status');
            $table->string('referral_code')->nullable()->after('profile_pic');
            $table->foreignId('referred_by')->nullable()->after('referral_code')->references('id')->on('users')->onDelete('cascade');
            $table->text('user_agent')->nullable()->after('referred_by');
            $table->string('created_ip')->nullable()->after('user_agent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->table('users', function (\App\Base\Database\BlueprintBase $table) {
            $table->dropConstrainedForeignId('country_id');
            $table->dropConstrainedForeignId('state_id');
            $table->dropConstrainedForeignId('city_id');
            $table->dropConstrainedForeignId('user_role_id');
            $table->dropConstrainedForeignId('referred_by');
            $table->dropColumn('status');
            $table->dropColumn('username');
            $table->dropColumn('profile_pic');
            $table->dropColumn('referral_code');
            $table->dropColumn('user_agent');
            $table->dropColumn('created_ip');
        });
    }
}