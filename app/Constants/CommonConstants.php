<?php

namespace App\Constants;

class CommonConstants
{
    const DISPLAY_DATE_FORMAT = 'm/d/Y';
    const DISPLAY_DATE_TIME_FORMAT = 'm/d/Y h:i A';

    const PHP_DATE_FORMAT = 'Y-m-d H:i:s';
    const PHP_DATE_FORMAT_SHORT = 'Y-m-d';

    const DEFAULT_REFERRAL_CODE = 'system';
    const DEFAULT_USER_ROLE = 2;

    const AFTER_LOGIN_REDIRECT_URL = 'dashboard';

    const ADMINISTRATIVE = 1;

    const DEFAULT_COUNTRY = 99;
    const DEFAULT_STATE = 1621;
    const DEFAULT_CITY = 18385;

    const UNLIMITED = -1;
    const UNLIMITED_COUNT = 99999;

    const CURRENCY_ICON = '₹';
    const CURRENCY_CODE = 'INR';

    const DATA_TYPE_STRING ="text";

    const YES = 1;
    const NO = 0;

    const YES_STRING = 'yes';
    const NO_STRING = 'no';

    const LIVE_WIRE_THEME = 'bootstrap-4';

    const YES_NO_PROPERTIES = [
        self::YES => ['class' => 'badge badge-success', 'text' => 'Yes'],
        self::NO => ['class' => 'badge badge-danger', 'text' => 'No']
    ];
}
