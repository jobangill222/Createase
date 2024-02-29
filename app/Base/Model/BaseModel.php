<?php

namespace App\Base\Model;

use App\Components\Helper;
use App\Constants\CommonConstants;
use App\Constants\LogConstants;
use App\Constants\UserConstants;
use App\Models\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BaseModel extends Model
{
    public $timestamps = false;

    protected static function booted()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->onCreating();
        });

        self::created(function ($model) {
            $model->onCreated();
        });

        self::updating(function ($model) {
            $model->onUpdating();
        });

        self::updated(function ($model) {
            $model->onUpdated();
        });

        self::deleting(function ($model) {
            $model->onDeleting();
        });

        self::deleted(function ($model) {
            $model->onDeleted();
        });

        self::saving(function ($model) {
            $model->onSaving();
        });

        self::saved(function ($model) {
            $model->onSaved();
        });
    }

    public static function nextDisplayOrder()
    {
        $count = 1;
        $row = self::query()->orderByDesc("display_order")->firstOrFail();
        if ($row != null) {
            $count += $row->display_order;
        }
        return $count;
    }

    public static function generateReferenceNumber()
    {
        $number = rand(1000, 9999) . rand(1000, 9999);
        $check = self::query()->where('ref_no', '=', $number)->first();
        if ($check != null) {
            return self::generateReferenceNumber();
        }
        return $number;
    }


    public function onCreating()
    {
        $ip = request()->ip();
        if (is_array($this->fillable)) {

            if (in_array('uuid', $this->fillable)) {
                $this->uuid = (string) Str::uuid();
            }
            if (in_array('ref_no', $this->fillable)) {
                $this->ref_no = (string) self::generateReferenceNumber();
            }

            if (in_array('created_at', $this->fillable)) {
                if ($this->created_at == null) {
                    $this->created_at = date(CommonConstants::PHP_DATE_FORMAT);
                }
            }

            if (in_array('created_ip', $this->fillable)) {
                if ($this->created_ip == null) {
                    $this->created_ip = $ip;
                }
            }

            if (in_array('updated_at', $this->fillable)) {
                if ($this->updated_at == null) {
                    $this->updated_at = date(CommonConstants::PHP_DATE_FORMAT);
                }
            }

            if (in_array('updated_ip', $this->fillable)) {
                if ($this->updated_ip == null) {
                    $this->updated_ip = $ip;
                }
            }

            // if (in_array('country_id', $this->fillable)) {
            //     if ($this->country_id == null) {
            //         $ipDetails = Helper::fetchIpDetails($ip, true);
            //         $this->country_id = ($ipDetails ? $ipDetails['country']->id : null);
            //     }

            //     if($this->country_id==null) {
            //         $this->country_id=CommonConstants::DEFAULT_COUNTRY;
            //     }
            // }

            if (in_array('user_agent', $this->fillable)) {
                if ($this->user_agent == null) {
                    $this->user_agent = request()->userAgent();
                }
            }

        }
    }


    public function scopeUserCheck($query)
    {
        $identity = \auth()->user();
        if (!$identity->isAdmin()) {
            if ($identity) {
                $query->where('user_id', $identity->id);
            } else {
                $query->where('user_id', -1);
            }
        }
    }

    public function onCreated()
    {
        $this->insertCreateUpdateLog();
    }

    public function onUpdating()
    {
        $ip = request()->ip();
        if (in_array('updated_at', $this->fillable)) {
            if ($this->updated_at == null) {
                $this->updated_at = date(CommonConstants::PHP_DATE_FORMAT);
            }
        }

        if (in_array('updated_ip', $this->fillable)) {
            if ($this->updated_ip == null) {
                $this->updated_ip = $ip;
            }
        }
    }

    public function onUpdated()
    {
        $this->insertCreateUpdateLog(false);
    }

    public function onDeleting()
    {
        //give implementation
    }

    public function onDeleted()
    {
        //give implementation
    }

    public function onSaving()
    {
        //give implementation
    }

    public function onSaved()
    {
        //give implementation
    }

    private function insertCreateUpdateLog($isNewRecord = true)
    {
        $calledClassTable = self::getTable();
        $logClass = new Log();
        $logClassTable = $logClass->getTable();
        if ($calledClassTable != $logClassTable) {
            if ($isNewRecord) {
                Log::insertLog([
                    'user_id' => Helper::getCurrentUserId(),
                    'particulars' => 'Record Created',
                    'type' => self::getTable() . '_create',
                    'data' => $this->attributesToArray()
                ]);
            } else {
                Log::insertLog([
                    'user_id' => Helper::getCurrentUserId(),
                    'particulars' => 'Record Updated',
                    'type' => self::getTable() . '_update',
                    'data' => $this->changedAttributes()
                ]);
            }
        }
    }

    public function changedAttributes()
    {
        $attributes = [];
        foreach ($this->original as $attributeKey => $attributeValue) {
            $newValue = $this->attributes[$attributeKey];
            if ($newValue != $attributeValue) {
                $attributes[$attributeKey] = [
                    'original' => $attributeValue,
                    'new' => $newValue
                ];
            }
        }
        return $attributes;
    }

    public static function buildFilterQuery(&$query, $filters, $userCondition = false, $userConditionColumn = 'user_id')
    {
        if ($userCondition) {
            $identity = \auth()->user();
            if ($identity) {
                if (!$identity->isAdmin()) {
                    $query->where($userConditionColumn, $identity->id);
                }
            }
        }
        $searchFilters = request()->input('search_query');
        $searchFilters = Helper::cleanArray($searchFilters);
        $filters = Helper::cleanArray($filters);
        if (is_array($searchFilters) && count($searchFilters) > 0) {
            if (is_array($filters) && count($filters) > 0) {
                foreach ($filters as $searchKey => $column) {
                    if (is_numeric($searchKey)) {
                        $searchKey = $column;
                    }
                    if (array_key_exists($searchKey, $searchFilters)) {
                        $searchString = trim($searchFilters[$searchKey]);
                        if ($searchString != null) {
                            if (is_string($column)) {
                                //$query->where($column, 'LIKE', '%' . $searchString . '%');
                                $query->where($column, $searchString);
                            } elseif (is_array($column)) {
                                $columns = $column;
                                $query->where(function ($q) use ($columns, $searchString) {
                                    foreach ($columns as $column) {
                                        $q->orWhere($column, 'LIKE', '%' . $searchString . '%');
                                    }
                                })->get();
                            }
                        }
                    }
                }
            }
        }
        $columns = request()->input('columns');
        $orders = request()->input('order');
        if (is_array($orders) && count($orders) > 0) {
            foreach ($orders as $order) {
                $columnKey = $order['column'];
                if (is_array($columns) && array_key_exists($columnKey, $columns)) {
                    $orderDir = $order['dir'];
                    $orderColumn = $columns[$columnKey]['name'];
                    $query->orderBy($orderColumn, $orderDir);
                }
            }
        }
    }

    public static function getTableName()
    {
        $calledClass = get_called_class();
        $class = new $calledClass();
        return $class->getTable();
    }

}