<?php

namespace Database\Seeders;

use App\Constants\CommonConstants;
use App\Constants\UserConstants;
use App\Models\Setting;
use App\Models\User;
use Faker\Provider\UserAgent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = array(
            //['id'=>CommonConstants::SETTING_APP_NAME,'name'=>'App Name','value'=>'none','type'=>CommonConstants::DATA_TYPE_STRING,'created_ip'=>request()->ip()],
        );

        foreach ($settings as $setting) {
            if(\App\Models\Setting::getValue($setting['id'])===false) {
                DB::table(Setting::getTableName())->insert($setting);
            }
        }
    }
}
