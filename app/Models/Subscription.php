<?php

namespace App\Models;

use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
