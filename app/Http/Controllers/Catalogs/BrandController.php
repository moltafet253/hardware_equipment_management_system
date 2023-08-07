<?php

namespace App\Http\Controllers\Catalogs;

use App\Models\Catalogs\Company;
use Illuminate\Http\Request;

class BrandController extends \App\Http\Controllers\Controller
{
    public function newBrand(Request $request)
    {
        $name=$request->input('name');
        $products=$request->input('products');
        $check=Company::where('name',$name)->first();

        if (!$name) {
            return $this->alerts(false, 'nameIsNull', 'نام شرکت وارد نشده است');
        }

        if (!$products){
            return $this->alerts(false, 'productIsNull', 'نوع محصول شرکت وارد نشده است');
        }

        if ($check) {
            return $this->alerts(false, 'repeatedName', 'نام شرکت تکراری وارد شده است');
        }

        $product=implode('|',$products);
        $car = new Company();
        $car->name = $name;
        $car->products = $product;
        $car->save();
        $this->logActivity('Company Added =>' . $name, request()->ip(), request()->userAgent(), session('id'));
        return $this->success(true, 'companyAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }
    public function index()
    {
        $brandList = Company::where('name','!=','ONBOARD')->orderBy('name', 'asc')->paginate(20);
        return view('Catalogs.Brands', ['brandList' => $brandList]);
    }
}
