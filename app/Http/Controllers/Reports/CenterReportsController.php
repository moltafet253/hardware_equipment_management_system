<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CenterReportsController extends Controller
{
    public function index()
    {
        return \view('Reports.CenterReport');
    }
}
