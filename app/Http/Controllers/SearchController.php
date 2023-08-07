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
        }
    }
}
