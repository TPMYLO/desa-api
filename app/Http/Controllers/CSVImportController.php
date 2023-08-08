<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\Villages;
use Illuminate\Support\Facades\DB;

class CSVImportController extends Controller
{
    public function importCSV()
    {
        $filePath = public_path('/villages.csv');
        $csvData  = array_map('str_getcsv', file($filePath));
        foreach ($csvData as $row) {
            Villages::create([
                'id' => $row[0],
                'district_id' => $row[1],
                'name' => $row[2],
            ]);
        }

        return "CSV data imported successfully.";
    }
}
