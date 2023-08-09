<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Motherboard;
use Illuminate\Http\Request;

class MotherboardController extends Controller
{
    public function newMotherboard(Request $request)
    {
        $brand=$request->input('brand');
        $generation=$request->input('mb_gen');
        $cpu_slot_num=$request->input('cpu_slot_num');
        $ram_slot_num=$request->input('ram_slot_num');
        $model=$request->input('model');
        $cpu_slot_type=$request->input('cpu_slot_type');
        $ram_slot_gen=$request->input('ram_slot_gen');
        if (!$brand){
            return $this->alerts(false, 'nullName', 'نام برند انتخاب نشده است');
        }
        if (!$cpu_slot_num){
            return $this->alerts(false, 'nullName', 'تعداد سوکت پردازنده انتخاب نشده است');
        }
        if (!$ram_slot_num){
            return $this->alerts(false, 'nullName', 'تعداد سوکت رم انتخاب نشده است');
        }
        if (!$model){
            return $this->alerts(false, 'nullName', 'مدل انتخاب نشده است');
        }
        if (!$cpu_slot_type){
            return $this->alerts(false, 'nullName', 'نوع اسلات پردازنده انتخاب نشده است');
        }
        if (!$ram_slot_gen){
            return $this->alerts(false, 'nullName', 'نسل اسلات رم انتخاب نشده است');
        }
        if (!$generation){
            return $this->alerts(false, 'nullName', 'نسل مادربورد وارد نشده است');
        }

        $MB=new Motherboard();
        $MB->company_id=$brand;
        $MB->model=$model;
        $MB->generation=$generation;
        $MB->ram_slot_generation=$ram_slot_gen;
        $MB->cpu_slot_type=$cpu_slot_type;
        $MB->cpu_slots_number=$cpu_slot_num;
        $MB->ram_slots_number=$ram_slot_num;
        $MB->save();
        $this->logActivity('Motherboard Added =>' . $MB->id , request()->ip(), request()->userAgent(), session('id'));
        return $this->success(true, 'motherboardAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');

    }
    public function index()
    {
        $mbList = Motherboard::orderBy('company_id', 'asc')->paginate(20);
        return view('Catalogs.MotherboardCatalog', ['mbList' => $mbList]);
    }
}
