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
        $command=Artisan::call('database:backup');
        if ($command===0) {
            $this->logActivity('Backup created!', request()->ip(), request()->userAgent(), session('id'));
            return $this->success(200, 'success', 'بکاپ با موفقیت ایجاد شد!');
        } else {
            return $this->alerts(false, 'error', 'اجرای دستور با خطا مواجه شد.');
        }
    }
}
