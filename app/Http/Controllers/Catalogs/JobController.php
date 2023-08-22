<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function newJob(Request $request)
    {
        $title = $request->input('title');
        if (!$title) {
            return $this->alerts(false, 'nullName', 'عنوان کار وارد نشده است');
        }
        $check = Job::where('title', $title)->first();
        if ($check) {
            return $this->alerts(false, 'dupName', 'عنوان کار تکراری وارد شده است');
        }
        $Job = new Job();
        $Job->title = $title;
        $Job->save();
        $this->logActivity('Job Added =>' . $Job->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'jobAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editJob(Request $request)
    {
        $editJobID = $request->input('job_id');
        $name = $request->input('titleForEdit');
        if (!$name) {
            return $this->alerts(false, 'nullName', 'عنوان کار وارد نشده است');
        }
        $check = Job::where('title', $name)->first();
        if ($check) {
            return $this->alerts(false, 'dupName', 'عنوان کار تکراری وارد شده است');
        }

        $Job = Job::find($editJobID);
        $Job->fill([
            'title' => $name,
        ]);
        $Job->save();
        $this->logActivity('Job Edited =>' . $editJobID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'jobEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getJobInfo(Request $request)
    {
        $JobID = $request->input('id');
        if ($JobID) {
            return Job::find($JobID);
        }
    }

    public function index()
    {
        $JobList = Job::orderBy('title', 'asc')->paginate(20);
        return \view('Catalogs.JobCatalog', ['JobList' => $JobList]);
    }
}
