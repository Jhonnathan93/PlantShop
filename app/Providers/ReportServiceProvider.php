<?php

namespace App\Providers;

use App\Interfaces\OrdersReport;
use App\Util\OrdersReportJson;
use App\Util\OrdersReportXSLX;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

class ReportServiceProvider extends ServiceProvider
{
    public function register(): void
    {

        $this->app->bind(OrdersReport::class, function ($app, array $params) {
            return match ($params['fileType'] ?? null) {
                'xlsx' => new OrdersReportXSLX(),
                'json' => new OrdersReportJson(),
                default => throw new InvalidArgumentException('Unsupported report format.'),
            };
        });
    }
}
