<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
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
                    $personInfo = Person::find($personID);
                    if ($personInfo) {
                        $pdf = Pdf::loadView('Reports.PDFReportPages.PersonEquipmentsReport', compact('personInfo'));
                        return $pdf->stream($personID . '.pdf');
                    }
                }
                return $this->alerts(false, 'nullPersonnelCode', 'پرسنل انتخاب نشده است');
                break;
        }
    }


    public function index()
    {
        return view('Reports.PDFReports');
    }
}
