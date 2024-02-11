<?php

namespace App\Base\Database;

use Illuminate\Database\Schema\Blueprint as BaseBlueprint;


class BlueprintBase extends BaseBlueprint
{
    public function createdAtTime($precision = 0)
    {
        $this->timestamp('created_at', $precision)->useCurrent();
    }

    public function updatedAtTime($precision = 0)
    {
        $this->timestamp('updated_at', $precision)->nullable()->useCurrentOnUpdate();
    }

    public function timestamps($precision = 0)
    {
        $this->createdAtTime();
        $this->updatedAtTime();
    }

    public function ipAddresses($includeUpdatedAt = false)
    {
        $this->ipAddress('created_ip');
        if ($includeUpdatedAt) {
            $this->ipAddress('updated_ip')->nullable();
        }
    }

    public function userAgent()
    {
        $this->string('user_agent', 1000);
    }
}






