<?php

namespace Database\Seeders;

use App\Constants\CommonConstants;
use App\Constants\UserConstants;
use App\Models\User;
use Faker\Provider\UserAgent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Back Office',
            'email' => 'admin@admin.com',
            'username' => 'backoffice',
            'email_verified_at' => date(CommonConstants::PHP_DATE_FORMAT),
            'password' => 'test@123',
            'user_role_id' => UserConstants::ROLE_ADMIN,
            'status' => UserConstants::STATUS_ACTIVE,
            'profile_pic' => null,
            'referral_code' => CommonConstants::DEFAULT_REFERRAL_CODE,
            'referred_by' => null,
            'user_agent' => UserAgent::chrome(),
            'created_ip' => '127.0.0.1',
            'remember_token' => Str::random(10),
            'created_at' => date(CommonConstants::PHP_DATE_FORMAT),
        ]);
    }
}
