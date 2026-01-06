<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// app/Events/OrderPaidEvent.php
class OrderPaidEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(public Order $order) {}
}