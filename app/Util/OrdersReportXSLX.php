<?php

namespace App\Util;

use App\Interfaces\OrdersReport;
use InvalidArgumentException;
use JsonException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class OrdersReportXSLX implements OrdersReport
{
    public function store(string $json): string
    {
        try {
            $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new InvalidArgumentException('Invalid report data.', 0, $exception);
        }

        if ($data === [] || ! is_array($data)) {
            throw new InvalidArgumentException('There are no orders to export.');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        foreach (array_keys($data[0]) as $column => $key) {
            $sheet->setCellValue([$column + 1, 1], $key);
        }

        foreach ($data as $row => $rowData) {
            foreach ($rowData as $column => $cell) {
                $sheet->setCellValue([$column + 1, $row + 2], $cell);
            }
        }

        $directory = storage_path('app/public/reports');
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        $filePath = $directory.'/orders-'.now()->format('YmdHisv').'.xlsx';
        (new Xlsx($spreadsheet))->save($filePath);

        return $filePath;
    }
}
