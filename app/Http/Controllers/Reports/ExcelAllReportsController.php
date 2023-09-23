<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelAllReportsController extends Controller
{
    public function getReport(Request $request)
    {
        $work=$request->input('work');
        switch ($work){
            case 'GetAllCenterPersonEqiupments':
                $person=$request->input('person');
                $personInfo=Person::find($person);

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet ->set();

                $sheet->setCellValue('A1', 'نام');
                $sheet->setCellValue('B1', 'نام خانوادگی');
                $sheet->setCellValue('A2', 'John');
                $sheet->setCellValue('B2', 'Doe');
                $writer = new Xlsx($spreadsheet);
                $filename = $person. '.xlsx';
                $writer->save($filename);

                return response()->download($filename)->deleteFileAfterSend(true);

                break;
        }

    }
    public function index()
    {
        return \view('Reports.ExcelAllReports');
    }
}
