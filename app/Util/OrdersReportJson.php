<?php

namespace App\Util;

use App\Interfaces\OrdersReport;
use InvalidArgumentException;
use JsonException;

class OrdersReportJson implements OrdersReport
{
    public function getContent(string $json): string
    {
        try {
            $formattedJson = json_encode(
                json_decode($json, true, 512, JSON_THROW_ON_ERROR),
                JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR
            );
        } catch (JsonException $exception) {
            throw new InvalidArgumentException('Invalid report data.', 0, $exception);
        }

        return $formattedJson;
    }

    public function getFileName(): string
    {
        return 'orders-'.now()->format('YmdHisv').'.json';
    }

    public function getMimeType(): string
    {
        return 'application/json';
    }
}
