<?php

namespace App\Util;

use App\Interfaces\OrdersReport;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use JsonException;

class OrdersReportJson implements OrdersReport
{
    public function store(string $json): string
    {
        try {
            $formattedJson = json_encode(
                json_decode($json, true, 512, JSON_THROW_ON_ERROR),
                JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR
            );
        } catch (JsonException $exception) {
            throw new InvalidArgumentException('Invalid report data.', 0, $exception);
        }

        $path = 'reports/orders-'.now()->format('YmdHisv').'.json';
        Storage::disk('public')->put($path, $formattedJson);

        return Storage::disk('public')->path($path);
    }
}
