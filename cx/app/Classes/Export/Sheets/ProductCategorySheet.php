<?php

declare(strict_types=1);

namespace App\Classes\Export\Sheets;

use App\Libs\UserInfo;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductCategorySheet implements FromArray, WithTitle, ShouldAutoSize, WithStyles, WithColumnWidths, WithHeadings
{
    private string $sheetName;
    private array $data;
    private $isRiel;

    public function __construct(string $sheetName, array $data)
    {
        $this->sheetName = $sheetName;
        $this->data = $data;
        $this->isRiel = app('User')->isRiel();
    }

    public function array(): array
    {
        return $this->data;
    }

    public function title(): string
    {
        return $this->sheetName;
    }

    public function headings(): array
    {
        $customerName = (new UserInfo(Auth::user()))->getCompanyName();

        $firstRow = [
            'RIEL ' . trans('pages/export.price_list') . ' (' . trans('pages/export.generated') . ': ' . date('Y.m.d') . ' – ' . $customerName . ') - ' . trans('pages/export.export_header'),
        ];

        $headers = [
            trans('pages/products.manufacture'),
            trans('pages/products.model_no'),
            trans('form.description'),
            trans('prices.list_price'),
            trans('prices.sale_price'),
            trans('prices.discounted_price'),
            trans('stocks.hu_stock'),
        ];

        if ($this->isRiel) {
            $headers[] = trans('stocks.eu_stock');
        }

        $headers = array_merge($headers, [
            trans('pages/products.sale'),
            trans('pages/products.project'),
            trans('pages/products.it_product'),
            trans('pages/products.category') . ' 1',
            trans('pages/products.category') . ' 2',
            trans('pages/products.category') . ' 3',
        ]);

        return [$firstRow, $headers];
    }

    public function styles(Worksheet $sheet): array
    {
        $coordinates = $this->isRiel ? ['first' => 'A1:N1', 'second' => 'A2:N2'] : ['first' => 'A1:N1', 'second' => 'A2:M2'];

        return [
            $coordinates['first'] => [
                'font' => [
                    'bold' => true,
                    'size' => 13,
                ],
            ],

            $coordinates['second'] => [
                'font' => [
                    'color' => ['argb' => Color::COLOR_WHITE],
                    'bold' => true,
                    'size' => 13,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF666666'],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        $widths = [
            'A' => 25, // Gyártó
            'B' => 50, // Cikkszám
            'C' => 100, // Leírás
            'D' => 15, // Listaár
            'E' => 15, // Akciós ár
            'F' => 25, // Kedvezményes ár
            'G' => 15, // Riel készlet
            'H' => 15, // EU készlet
            'I' => 15, // Akciós
            'J' => 20, // Projekt termék
            'K' => 15, // IT termék
            'L' => 30, // Kategória 1
        ];

        if ($this->isRiel) {
            $widths['M'] = 30;
            $widths['N'] = 30;
        }

        return $widths;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // nyomtatási terület beállítása
                $areaLength = sizeof($this->data) + 2;
                $printArea = 'A1:F' . $areaLength;

                $event->sheet->getDelegate()->getPageSetup()->setPrintArea($printArea);
                $event->sheet->getDelegate()->getPageSetup()->setScale(45)->setHorizontalCentered(true);
                $event->sheet->getDelegate()->getPageSetup()->setRowsToRepeatAtTop([1, 2]);
            },
        ];
    }
}
