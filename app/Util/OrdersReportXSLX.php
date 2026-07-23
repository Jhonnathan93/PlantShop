<?php

namespace App\Util;

use App\Interfaces\OrdersReport;
use InvalidArgumentException;
use JsonException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class OrdersReportXSLX implements OrdersReport
{
    public function getContent(string $json): string
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

        ob_start();
        (new Xlsx($spreadsheet))->save('php://output');
        $content = ob_get_clean();
        $spreadsheet->disconnectWorksheets();

        if ($content === false) {
            throw new InvalidArgumentException('Unable to generate the XLSX report.');
        }

        return $content;
    }

    public function getFileName(): string
    {
        return 'orders-'.now()->format('YmdHisv').'.xlsx';
    }

    public function getMimeType(): string
    {
        return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    }
}
