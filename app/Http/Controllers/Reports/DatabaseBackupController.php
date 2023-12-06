<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DatabaseBackupController extends Controller
{
    public function index()
    {
        return view('Reports.DatabaseBackup');
    }

    public function createBackup()
    {
        if (Artisan::call('database:backup')) {
            $this->logActivity('Backup created!', request()->ip(), request()->userAgent(), session('id'));
            return response()->json(['status' => 'success', 'output' => $output]);
        } else {
            return $this->alerts(false, 'error', 'اجرای دستور با خطا مواجه شد.');
        }
    }
}
