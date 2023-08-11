<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\GraphicCard;
use Illuminate\Http\Request;

class GraphicCardController extends Controller
{

    public function newGraphicCard(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');
        $ram_size = $request->input('ram_size');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$ram_size) {
            return $this->alerts(false, 'nullRamSize', 'سایز حافظه انتخاب نشده است');
        }

        $GraphicCard = new GraphicCard();
        $GraphicCard->company_id = $brand;
        $GraphicCard->model = $model;
        $GraphicCard->ram_size = $ram_size;
        $GraphicCard->save();
        $this->logActivity('GraphicCard Added =>' . $GraphicCard->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'graphiccardAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }
    public function editGraphicCard(Request $request)
    {
        $GraphicCardID = $request->input('graphiccard_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        $ram_size = $request->input('ram_sizeForEdit');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$ram_size) {
            return $this->alerts(false, 'nullRamSize', 'سایز حافظه انتخاب نشده است');
        }

        $GraphicCard = GraphicCard::find($GraphicCardID);
        $GraphicCard->fill([
            'company_id' => $brand,
            'model' => $model,
            'ram_size' => $ram_size,
        ]);
        $GraphicCard->save();
        $this->logActivity('GraphicCard Edited =>' . $GraphicCard, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'graphiccardEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }
    public function getGraphicCardInfo(Request $request)
    {
        $graphiccardID = $request->input('id');
        if ($graphiccardID) {
            return GraphicCard::find($graphiccardID);
        }
    }
    public function index()
    {
        $graphiccardList = GraphicCard::where('model','!=','ONBOARD')->orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.GraphicCardCatalog', ['graphiccardList' => $graphiccardList]);
    }
}
