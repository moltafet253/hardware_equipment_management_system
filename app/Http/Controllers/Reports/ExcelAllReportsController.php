<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Assistance;
use App\Models\Catalogs\Cases;
use App\Models\Catalogs\Company;
use App\Models\Catalogs\cpu;
use App\Models\Catalogs\Motherboard;
use App\Models\Catalogs\Power;
use App\Models\Catalogs\Ram;
use App\Models\EquipmentedCase;
use App\Models\EstablishmentPlace;
use App\Models\ExecutivePosition;
use App\Models\Person;
use App\Models\Province;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelAllReportsController extends Controller
{
    public function getCompanyInfo($companyID)
    {
        $company = Company::find($companyID);
        if ($company){
            return $company->name;
        }
        return null;
    }

    public function getReport(Request $request)
    {
        $work = $request->input('work');
        switch ($work) {
            case 'GetAllPersonEqiupments':
                $person = $request->input('person');
                $personInfo = Person::find($person);

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setRightToLeft(true);

                $sheet->mergeCells('A1:K1');
                $cell = $sheet->getCell('A1');
                $cell->getStyle()->getFont()->setBold(true);
                $cell->getStyle()->getFont()->setSize(15);
//                $cell->getStyle()->getFont()->setColor(new Color(Color::COLOR_RED));

                $headerCellValue = 'گزارش تجهیزات پرسنل با مشخصات:  ' . $personInfo->name . ' ' . $personInfo->family;
                $headerCellValue .= ' - کد پرسنلی: ' . $personInfo->personnel_code;
                $headerCellValue .= ' - کد ملی: ' . $personInfo->national_code;
                $sheet->setCellValue('A1', $headerCellValue);

                //Getting Information
                $sheet->setCellValue('A3', 'کیس ها');
                $cases=EquipmentedCase::where('person_id',$personInfo->id)->get();
                foreach ($cases as $key=>$case){
                    $caseInfo=Cases::find($case->case);
                    $powerInfo=Power::find($caseInfo->power);
                    $motherboardInfo=Motherboard::find($caseInfo->motherboard);
                    $cpuInfo=cpu::find($caseInfo->cpu);
                    if ($case->ram1){
                        $ram1Info=Ram::find($case->ram1);
                    }
                    if ($case->ram2){
                        $ram2Info=Ram::find($case->ram2);
                    }
                    if ($case->ram3){
                        $ram3Info=Ram::find($case->ram3);
                    }
                    if ($case->ram4){
                        $ram4Info=Ram::find($case->ram4);
                    }
                    $sheet->setCellValue('A' . $key+=4 ,$this->getCompanyInfo($caseInfo->company_id).'\n' );
                }


                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

                $writer = new Xlsx($spreadsheet);
                $filename = $personInfo->personnel_code . '.xlsx';
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
