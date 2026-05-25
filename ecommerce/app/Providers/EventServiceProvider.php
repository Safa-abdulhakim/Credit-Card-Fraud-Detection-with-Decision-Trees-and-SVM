<?php
namespace App\Providers;

use App\Events\OrderPlaced;
use App\Events\OrderCancelled;
use App\Listeners\SendOrderConfirmationEmail;
use App\Listeners\UpdateVendorEarnings;
use App\Listeners\NotifyVendorOfNewOrder;
use App\Listeners\RestoreStockOnCancellation;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderPlaced::class => [
            SendOrderConfirmationEmail::class,
            UpdateVendorEarnings::class,
            NotifyVendorOfNewOrder::class,
        ],
        OrderCancelled::class => [
            RestoreStockOnCancellation::class,
        ],
    ];
}
