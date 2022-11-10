<?php

namespace App\Http\Controllers;

use App\Classes\Export\PriceListExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PriceListExportController extends Controller
{
    public function index()
    {
        $types = [];

        foreach ($this->getTypes() as $type) {
            $types[$type] = '.' . $type;
        }

        return view('pages.price-list-export', [
            'types' => $types,
        ]);
    }

    public function download(Request $request): BinaryFileResponse
    {
        $type = $request->type;

        if (! in_array($type, $this->getTypes())) {
            abort(404);
        }

        return Excel::download(new PriceListExport(), 'riel_arlista_' . date('Y-m-d') . '.' . $type);
    }

    private function getTypes(): array
    {
        return ['xlsx', 'xls', 'csv'];
    }
}
