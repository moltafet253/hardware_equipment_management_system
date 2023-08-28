<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Motherboard;
use Illuminate\Http\Request;

class MotherboardController extends Controller
{
    public function newMotherboard(Request $request)
    {
        $brand = $request->input('brand');
        $generation = $request->input('mb_gen');
        $cpu_slot_num = $request->input('cpu_slot_num');
        $ram_slot_num = $request->input('ram_slot_num');
        $model = $request->input('model');
        $cpu_slot_type = $request->input('cpu_slot_type');
        $ram_slot_gen = $request->input('ram_slot_gen');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
//        if (!$cpu_slot_num) {
//            return $this->alerts(false, 'nullCPUSlotNumbers', 'تعداد سوکت پردازنده انتخاب نشده است');
//        }
//        if (!$ram_slot_num) {
//            return $this->alerts(false, 'nullRAMSlotNumbers', 'تعداد سوکت رم انتخاب نشده است');
//        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
//        if (!$cpu_slot_type) {
//            return $this->alerts(false, 'nullCPUSlotType', 'نوع اسلات پردازنده انتخاب نشده است');
//        }
//        if (!$ram_slot_gen) {
//            return $this->alerts(false, 'nullRamSlotGeneration', 'نسل اسلات رم انتخاب نشده است');
//        }
//        if (!$generation) {
//            return $this->alerts(false, 'nullGeneration', 'نسل مادربورد وارد نشده است');
//        }

        $MB = new Motherboard();
        $MB->company_id = $brand;
        $MB->model = $model;
        $MB->generation = $generation;
        $MB->ram_slot_generation = $ram_slot_gen;
        $MB->cpu_slot_type = $cpu_slot_type;
        $MB->cpu_slots_number = $cpu_slot_num;
        $MB->ram_slots_number = $ram_slot_num;
        $MB->save();
        $this->logActivity('Motherboard Added =>' . $MB->id, request()->ip(), request()->userAgent(), session('id'));
        return $this->success(true, 'motherboardAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editMotherboard(Request $request)
    {
        $MBID = $request->input('mb_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        $generation = $request->input('mb_genForEdit');
        $cpu_slot_num = $request->input('cpu_slot_numForEdit');
        $ram_slot_num = $request->input('ram_slot_numForEdit');
        $cpu_slot_type = $request->input('cpu_slot_typeForEdit');
        $ram_slot_gen = $request->input('ram_slot_genForEdit');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$cpu_slot_num) {
            return $this->alerts(false, 'nullCPUSlotNumbers', 'تعداد سوکت پردازنده انتخاب نشده است');
        }
        if (!$ram_slot_num) {
            return $this->alerts(false, 'nullRAMSlotNumbers', 'تعداد سوکت رم انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$cpu_slot_type) {
            return $this->alerts(false, 'nullCPUSlotType', 'نوع اسلات پردازنده انتخاب نشده است');
        }
        if (!$ram_slot_gen) {
            return $this->alerts(false, 'nullRamSlotGeneration', 'نسل اسلات رم انتخاب نشده است');
        }
        if (!$generation) {
            return $this->alerts(false, 'nullGeneration', 'نسل مادربورد وارد نشده است');
        }

        $MB = Motherboard::find($MBID);
        $MB->fill([
            'company_id' => $brand,
            'model' => $model,
            'generation' => $generation,
            'ram_slot_generation' => $ram_slot_gen,
            'cpu_slot_type' => $cpu_slot_type,
            'cpu_slots_number' => $cpu_slot_num,
            'ram_slots_number' => $ram_slot_num
        ]);
        $MB->save();
        $this->logActivity('Motherboard Edited =>' . $MBID, request()->ip(), request()->userAgent(), session('id'));
        return $this->success(true, 'motherboardEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getMotherboardInfo(Request $request)
    {
        $mbID = $request->input('id');
        if ($mbID) {
            return Motherboard::find($mbID);
        }
    }

    public function index()
    {
        $mbList = Motherboard::orderBy('company_id', 'asc')->paginate(20);
        return view('Catalogs.MotherboardCatalog', ['mbList' => $mbList]);
    }
}
