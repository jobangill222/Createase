<?php

namespace App\Constants;

class UserConstants
{
    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;

    const STATUS_DELETED = 'deleted';
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';


    const STATUS_PROPERTIES = [
        self::STATUS_ACTIVE => ['class' => 'badge badge-success', 'text' => 'Active'],
        self::STATUS_INACTIVE => ['class' => 'badge badge-danger', 'text' => 'In-Active']
    ];
}
