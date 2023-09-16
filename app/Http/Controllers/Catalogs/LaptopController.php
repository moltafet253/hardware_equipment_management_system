<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\OtherEquipments\Laptop;
use Illuminate\Http\Request;

class LaptopController extends Controller
{
    public function newLaptop(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');
        $cpu = $request->input('cpu');
        $graphic_card = $request->input('graphic_card');
        $screen_size = $request->input('screen_size');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$cpu) {
            return $this->alerts(false, 'nullCPU', 'پردازنده وارد نشده است');
        }

        $Laptop = new Laptop();
        $Laptop->company_id = $brand;
        $Laptop->model = $model;
        $Laptop->cpu = $cpu;
        if ($graphic_card) {
            $Laptop->graphic_card = $graphic_card;
        }
        if ($screen_size) {
            $Laptop->screen_size = $screen_size;
        }
        $Laptop->save();
        $this->logActivity('Laptop Added =>' . $Laptop->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'laptopAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editLaptop(Request $request)
    {
        $LaptopID = $request->input('laptop_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        $cpu = $request->input('cpuForEdit');
        $graphic_card = $request->input('graphic_cardForEdit');
        $screen_size = $request->input('screen_sizeForEdit');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$cpu) {
            return $this->alerts(false, 'nullCPU', 'پردازنده وارد نشده است');
        }
        if (!$graphic_card) {
            return $this->alerts(false, 'nullGraphicCard', 'پردازنده وارد نشده است');
        }

        $Laptop = Laptop::find($LaptopID);
        $Laptop->fill([
            'company_id' => $brand,
            'model' => $model,
            'cpu' => $cpu,
            'graphic_card' => $graphic_card,
            'screen_size' => $screen_size,
        ]);
        $Laptop->save();
        $this->logActivity('Laptop Edited =>' . $LaptopID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'laptopEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getLaptopInfo(Request $request)
    {
        $LaptopID = $request->input('id');
        if ($LaptopID) {
            return Laptop::find($LaptopID);
        }
    }

    public function index()
    {
        $laptopList = Laptop::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.OtherEquipments.LaptopCatalog', ['laptopList' => $laptopList]);
    }
}
