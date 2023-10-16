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
        $personID=$request->input('person');
        if ($personID) {
            $personInfo=Person::find($personID);
            if($personInfo) {
                $pdf = Pdf::loadView('Reports.PDFReportPages.PersonEquipmentsReport', compact('personInfo'));
                return $pdf->stream('report.pdf');
            }
        }
    }


    public function index()
    {
        return view('Reports.PDFReports');
    }
}
