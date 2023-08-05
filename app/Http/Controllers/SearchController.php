<?php

namespace App\Http\Controllers;

use App\Models\CarType;
use App\Models\Contractor;
use App\Models\Load;
use App\Models\Org;
use App\Models\Rider;
use App\Models\Tariff;
use App\Models\User;
use App\Models\Weighbridge;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $work = $request->input('work');
        switch ($work) {
            case 'CarCatalogSearch':
                $code = $request->input('code');
                $name = $request->input('name');
                $search = CarType::query();
                if ($code && $name) {
                    $search->where('CarCode', 'LIKE', '%' . $code . '%')->where('CarName', 'LIKE', '%' . $name . '%');
                    $this->logActivity('Search In Car Catalog With Code => ' . $code . ' And Name => ' . $name, request()->ip(), request()->userAgent(), session('id'));
                } elseif ($code) {
                    $search->where('CarCode', 'LIKE', '%' . $code . '%');
                    $this->logActivity('Search In Car Catalog With Code => ' . $code, request()->ip(), request()->userAgent(), session('id'));
                } elseif ($name) {
                    $search->where('CarName', 'LIKE', '%' . $name . '%');
                    $this->logActivity('Search In Car Catalog With Name => ' . $name, request()->ip(), request()->userAgent(), session('id'));
                }
                $result = $search->get();
                return response()->json($result);
            case 'OrgCatalogSearch':
                $code = $request->input('code');
                $name = $request->input('name');
                $search = Org::query();

                if ($code && $name) {
                    $search->where('OrgCode', 'LIKE', '%' . $code . '%')->where('OrgName', 'LIKE', '%' . $name . '%');
                    $this->logActivity('Search In Organization Catalog With Code => ' . $code . ' And Name => ' . $name, request()->ip(), request()->userAgent(), session('id'));
                } elseif ($code) {
                    $search->where('OrgCode', 'LIKE', '%' . $code . '%');
                    $this->logActivity('Search In Organization Catalog With Code => ' . $code, request()->ip(), request()->userAgent(), session('id'));
                } elseif ($name) {
                    $search->where('OrgName', 'LIKE', '%' . $name . '%');
                    $this->logActivity('Search In Organization Catalog With Name => ' . $name, request()->ip(), request()->userAgent(), session('id'));
                }
                $result = $search->get();
                return response()->json($result);
            case 'WBCatalogSearch':
                $code = $request->input('code');
                $name = $request->input('name');
                $search = Weighbridge::query();

                if ($code && $name) {
                    $search->where('WBCode', 'LIKE', '%' . $code . '%')->where('WBName', 'LIKE', '%' . $name . '%')->where('OrgCode', session('id'));
                    $this->logActivity('Search In Weighbridge Catalog With Code => ' . $code . ' And Name => ' . $name, request()->ip(), request()->userAgent(), session('id'));
                } elseif ($code) {
                    $search->where('WBCode', 'LIKE', '%' . $code . '%')->where('OrgCode', session('id'));
                    $this->logActivity('Search In Weighbridge Catalog With Code => ' . $code, request()->ip(), request()->userAgent(), session('id'));
                } elseif ($name) {
                    $search->where('WBName', 'LIKE', '%' . $name . '%')->where('OrgCode', session('id'));
                    $this->logActivity('Search In Weighbridge Catalog With Name => ' . $name, request()->ip(), request()->userAgent(), session('id'));
                } else {
                    $search->where('OrgCode', session('id'));
                }
                $result = $search->get();
                return response()->json($result);
            case 'LoadCatalogSearch':
                $code = $request->input('code');
                $name = $request->input('name');
                $search = Load::query();
                if ($code && $name) {
                    $search->where('LoadCode', 'LIKE', '%' . $code . '%')->where('LoadName', 'LIKE', '%' . $name . '%')->where('OrgCode', session('id'));
                    $this->logActivity('Search In Load Catalog With Code => ' . $code . ' And Name => ' . $name, request()->ip(), request()->userAgent(), session('id'));
                } elseif ($code) {
                    $search->where('LoadCode', 'LIKE', '%' . $code . '%')->where('OrgCode', session('id'));
                    $this->logActivity('Search In Load Catalog With Code => ' . $code, request()->ip(), request()->userAgent(), session('id'));
                } elseif ($name) {
                    $search->where('LoadName', 'LIKE', '%' . $name . '%')->where('OrgCode', session('id'));
                    $this->logActivity('Search In Load Catalog With Name => ' . $name, request()->ip(), request()->userAgent(), session('id'));
                } else {
                    $search->where('OrgCode', session('id'));
                }
                $result = $search->get();
                return response()->json($result);
            case 'ContractorCatalogSearch':
                $code = $request->input('code');
                $name = $request->input('name');
                $search = Contractor::query();
                if ($code && $name) {
                    $search->where('ContCode', 'LIKE', '%' . $code . '%')->where('ContName', 'LIKE', '%' . $name . '%')->where('OrgCode', session('id'));
                    $this->logActivity('Search In Contractor Catalog With Code => ' . $code . ' And Name => ' . $name, request()->ip(), request()->userAgent(), session('id'));
                } elseif ($code) {
                    $search->where('ContCode', 'LIKE', '%' . $code . '%')->where('OrgCode', session('id'));
                    $this->logActivity('Search In Contractor Catalog With Code => ' . $code, request()->ip(), request()->userAgent(), session('id'));
                } elseif ($name) {
                    $search->where('ContName', 'LIKE', '%' . $name . '%')->where('OrgCode', session('id'));
                    $this->logActivity('Search In Contractor Catalog With Name => ' . $name, request()->ip(), request()->userAgent(), session('id'));
                } else {
                    $search->where('OrgCode', session('id'));
                }
                $result = $search->get();
                return response()->json($result);
            case 'RiderCatalogSearch':
                $code = $request->input('code');
                $name = $request->input('name');
                $family = $request->input('family');
                $contractor = $request->input('cont');
                $search = Rider::query();
                $search->where('nationalCode', 'LIKE', '%' . $code . '%')->where('Name', 'LIKE', '%' . $name . '%')->where('Family', 'LIKE', '%' . $family . '%')->where('ContCode', 'LIKE', '%' . $contractor . '%')->where('OrgCode', session('id'));
                $this->logActivity('Search In Rider Catalog With Code => ' . $code . ' And Name => ' . $name . ' And Family => ' . $family . ' And ContCode => ' . $contractor, request()->ip(), request()->userAgent(), session('id'));
                $result = $search->get();
                return response()->json($result);
            case 'TariffCatalogSearch':
                $tariffCode = $request->input('tariffCode');
                $carCode = $request->input('carCode');
                $loadCode = $request->input('loadCode');
                $tariffPrice = $request->input('tariffPrice');
                $search = Tariff::query()
                    ->with(['cars', 'loads'])
                    ->where('TariffCode', 'LIKE', '%' . $tariffCode . '%')
                    ->where('CarCode', 'LIKE', '%' . $carCode . '%')
                    ->where('LoadCode', 'LIKE', '%' . $loadCode . '%')
                    ->where('tariff', 'LIKE', '%' . $tariffPrice . '%')
                    ->where('OrgCode', session('id'));
                $this->logActivity('Search In Tariff Catalog With Tariff Code => ' . $tariffCode . ' And CarCode => ' . $carCode . ' And LoadCode => ' . $loadCode, request()->ip(), request()->userAgent(), session('id'));
                $result = $search->get();
                return response()->json($result);
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
