<?php

namespace App\Models;

use App\Base\Model\BaseModel;
use App\Constants\CommonConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends BaseModel
{
    public static function getValue($id)
    {
        $model=self::query()->where('id','=',$id)
            ->limit(1)->first();
        if($model) {
            if($model->type==CommonConstants::DATA_TYPE_STRING) {
                return trim($model->value);
            } else {
                return $model->value;
            }
        }
        return false;
    }

    public function getActualValueAttribute()
    {
        if($this->type=="dropdown") {
        }
        return $this->value;
    }
}
