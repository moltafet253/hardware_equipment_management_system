<?php

namespace App\Http\Controllers\Catalogs;

use App\Models\Catalogs\Company;
use Illuminate\Http\Request;
use function Ybazli\Faker\string;

class BrandController extends \App\Http\Controllers\Controller
{
    public function newBrand(Request $request)
    {
        $name = $request->input('name');
        $products = $request->input('products');
        $check = Company::where('name', $name)->first();

        if (!$name) {
            return $this->alerts(false, 'nameIsNull', 'نام شرکت وارد نشده است');
        }

        if (!$products) {
            return $this->alerts(false, 'productIsNull', 'نوع محصول شرکت وارد نشده است');
        }

        if ($check) {
            return $this->alerts(false, 'repeatedName', 'نام شرکت تکراری وارد شده است');
        }

        $product = json_encode($products);
        $company = new Company();
        $company->name = $name;
        $company->products = $product;
        $company->save();
        $this->logActivity('Company Added =>' . $name , request()->ip(), request()->userAgent(), session('id'));
        return $this->success(true, 'companyAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editBrand(Request $request)
    {
        $companyID = $request->input('companyID');
        $name = $request->input('editedName');
        $products = $request->input('editedProducts');

        if (!$name) {
            return $this->alerts(false, 'nameIsNull', 'نام شرکت وارد نشده است');
        }

        if (!$products) {
            return $this->alerts(false, 'productIsNull', 'نوع محصول شرکت وارد نشده است');
        }

        $product = json_encode($products);
        $company = Company::find($companyID);
        $company->update([
            'name' => $name,
            'products' => $product,
        ]);
        $this->logActivity('Company Edited =>' . $name , request()->ip(), request()->userAgent(), session('id'));
        return $this->success(true, 'companyEdited', 'برای نمایش اطلاعات به روز شده، لطفا صفحه را رفرش نمایید.');
    }

    public function getBrandInfo(Request $request)
    {
        $id = $request->input('id');
        if ($id) {
            return Company::find($id);
        }
    }

    public function index()
    {
        $brandList = Company::where('name', '!=', 'ONBOARD')->orderBy('name', 'asc')->paginate(20);
        return view('Catalogs.Brands', ['brandList' => $brandList]);
    }
}
