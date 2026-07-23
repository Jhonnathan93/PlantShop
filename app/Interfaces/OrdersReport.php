<?php

namespace App\Interfaces;

interface OrdersReport
{
    public function getContent(string $json): string;

    public function getFileName(): string;

    public function getMimeType(): string;
}
