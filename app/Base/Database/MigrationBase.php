<?php

namespace App\Base\Database;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Class MigrationBase
 * @package App\Base\Database
 * @property Builder $schema
 */

class MigrationBase extends Migration
{
    public $schema;

    public function __construct()
    {
        $this->schema = DB::connection()->getSchemaBuilder();
        $this->schema->blueprintResolver(function($table, $callback) {
            return new BlueprintBase($table, $callback);
        });
    }

    public function up()
    {

    }

}
