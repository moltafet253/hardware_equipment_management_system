<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Printer;
use Illuminate\Http\Request;

class PrinterController extends Controller
{
    public function newPrinter(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');
        $functionType = $request->input('function_type');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$functionType) {
            return $this->alerts(false, 'nullFunctionType', 'نوع کارکرد انتخاب نشده است');
        }

        $Printer = new Printer();
        $Printer->company_id = $brand;
        $Printer->model = $model;
        $Printer->function_type = $functionType;
        $Printer->save();
        $this->logActivity('Printer Added =>' . $Printer->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'printerAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editPrinter(Request $request)
    {
        $PrinterID = $request->input('printer_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        $functionType = $request->input('function_typeForEdit');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$functionType) {
            return $this->alerts(false, 'nullFunctionType', 'نوع کارکرد انتخاب نشده است');
        }

        $Printer = Printer::find($PrinterID);
        $Printer->fill([
            'company_id' => $brand,
            'model' => $model,
            'function_type' => $functionType,
        ]);
        $Printer->save();
        $this->logActivity('Printer Edited =>' . $PrinterID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'printerEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getPrinterInfo(Request $request)
    {
        $PrinterID = $request->input('id');
        if ($PrinterID) {
            return Printer::find($PrinterID);
        }
    }

    public function index()
    {
        $printerList = Printer::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.PrinterCatalog', ['printerList' => $printerList]);
    }
}
