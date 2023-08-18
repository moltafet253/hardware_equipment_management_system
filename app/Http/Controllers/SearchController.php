<?php

namespace App\Http\Controllers;

use App\Models\Catalogs\Company;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $work = $request->input('work');
        switch ($work) {
            case 'BrandCatalogSearch':
                $name = $request->input('name');
                $search = Company::query();
                if ($name) {
                    $search->where('name', 'LIKE', '%' . $name . '%');
                    $search->where('name','!=','ONBOARD');
                    $this->logActivity('Search In Company Catalog With Name => ' . $name, request()->ip(), request()->userAgent(), session('id'));
                }else{
                    $search->where('name', 'LIKE', '%' . '%');
                    $search->where('name','!=','ONBOARD');
                }
                $search->orderBy('name','asc');
                $result = $search->get();
                return response()->json($result);
                break;
            case 'UserManagerSearch':
                $username = $request->input('username');
                $type = $request->input('type');
                $search = User::query();
                if ($username && $type) {
                    $search->where('username', 'LIKE', '%' . $username . '%')
                        ->where(function ($query) use ($type) {
                            $query->where('type', $type);
                        });
                    $this->logActivity('Search In User Manager With Username => ' . $username . ' And Type => ' . $type, request()->ip(), request()->userAgent(), session('id'));
                } elseif ($username) {
                    $search->where('username', 'LIKE', '%' . $username . '%');
                    $this->logActivity('Search In User Manager With Username => ' . $username, request()->ip(), request()->userAgent(), session('id'));
                } elseif ($type) {
                    $search->where(function ($query) use ($type) {
                        $query->where('type', $type);
                    });
                    $this->logActivity('Search In User Manager With Type => ' . $type, request()->ip(), request()->userAgent(), session('id'));
                }
                $result = $search->get();
                return response()->json($result);
        }
    }
}
