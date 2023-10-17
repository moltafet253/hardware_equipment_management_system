<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\EquipmentLog;
use App\Models\Person;
use Illuminate\Http\Request;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class PDFReportController extends Controller
{
    public function generatePDF(Request $request)
    {
        $message = null;
        switch ($request->input('work')) {
            case 'GetAllPersonEqiupments':
                $personID = $request->input('person');
                if ($personID) {
                    $personAddedEquipments=EquipmentLog::where('title','like','%Equipment Added%')->where('personal_code',$personID)->get();
                    $personMovedEquipments=EquipmentLog::where('title','like','%Equipment Moved%')->where('personal_code',$personID)->get();
                    if ($personAddedEquipments!=$personMovedEquipments) {
                        $personInfo = Person::find($personID);
                        $pdf = Pdf::loadView('Reports.PDFReportPages.PersonEquipmentsReport', compact('personInfo'));
                        return $pdf->stream($personID . '.pdf');
                    }
                    return $this->alerts(false, 'nullPersonnelEquipment', 'برای این پرسنل تجهیزاتی وارد نشده است');
                }
                return $this->alerts(false, 'nullPersonnelCode', 'پرسنل انتخاب نشده است');
                break;
            case 'GetAllAssistanceEqiupments':

                break;
        }
    }


    public function index()
    {
        return view('Reports.PDFReports');
    }
}
