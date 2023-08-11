<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\NetworkCard;
use Illuminate\Http\Request;

class NetworkCardController extends Controller
{
    public function newNetworkCard(Request $request)
    {
        $brand=$request->input('brand');
        $model=$request->input('model');
        $connectivity_type=$request->input('connectivity_type');
        if (!$brand){
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model){
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$connectivity_type){
            return $this->alerts(false, 'nullConnectivityType', 'نوع اتصال انتخاب نشده است');
        }

        $NetworkCard=new NetworkCard();
        $NetworkCard->company_id=$brand;
        $NetworkCard->model=$model;
        $NetworkCard->connectivity_type=$connectivity_type;
        $NetworkCard->save();
        $this->logActivity('Network Card Added =>' . $NetworkCard->id , \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'NetworkCardAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }
    public function editNetworkCard(Request $request)
    {
        $NetworkCardID=$request->input('NetworkCard_id');
        $brand=$request->input('brandForEdit');
        $model=$request->input('modelForEdit');
        $connectivity_type=$request->input('connectivity_typeForEdit');
        if (!$brand){
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model){
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$connectivity_type){
            return $this->alerts(false, 'nullConnectivityType', 'نوع اتصال انتخاب نشده است');
        }

        $NetworkCard=NetworkCard::find($NetworkCardID);
        $NetworkCard->fill([
            'company_id' => $brand,
            'model' => $model,
            'connectivity_type' => $connectivity_type,
        ]);
        $NetworkCard->save();
        $this->logActivity('Network Card Edited =>' . $NetworkCardID , \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'NetworkCardEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }
    public function getNetworkCardInfo(Request $request)
    {
        $NetworkCardID=$request->input('id');
        if ($NetworkCardID) {
            return NetworkCard::find($NetworkCardID);
        }
    }
    public function index()
    {
        $NetworkCardList = NetworkCard::where('model','!=','ONBOARD')->orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.NetworkCardCatalog', ['NetworkCardList' => $NetworkCardList]);
    }
}
