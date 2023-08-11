<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function newPerson(Request $request)
    {
        $name = $request->input('name');
        $family = $request->input('family');
        $personnel_code = $request->input('personnel_code');
        $phone = $request->input('phone');
        $mobile = $request->input('mobile');
        $net_username = $request->input('net_username');
        $room_number = $request->input('room_number');
        $assistance = $request->input('assistance');
        if (!$name) {
            return $this->alerts(false, 'nullName', 'نام وارد نشده است');
        }
        if (!$family) {
            return $this->alerts(false, 'nullFamily', 'نام خانوادگی وارد نشده است');
        }
        if (!$personnel_code) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }

        $check=Person::where('personnel_code',$personnel_code)->first();
        if ($check){
            return $this->alerts(false, 'dupPersonnelCode', 'کد پرسنلی تکراری وارد شده است');
        }

        $Person = new Person();
        $Person->name = $name;
        $Person->family = $family;
        $Person->personnel_code = $personnel_code;
        $Person->phone = $phone;
        $Person->mobile = $mobile;
        $Person->net_username = $net_username;
        $Person->room_number = $room_number;
        $Person->assistance = $assistance;
        $Person->save();
        $this->logActivity('Person Added =>' . $Person->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'PersonAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editPerson(Request $request)
    {
        $PersonID=$request->input('personID');
        $name = $request->input('nameForEdit');
        $family = $request->input('familyForEdit');
        $phone = $request->input('phoneForEdit');
        $mobile = $request->input('mobileForEdit');
        $net_username = $request->input('net_usernameForEdit');
        $room_number = $request->input('room_numberForEdit');
        $assistance = $request->input('assistanceForEdit');
        if (!$name) {
            return $this->alerts(false, 'nullName', 'نام وارد نشده است');
        }
        if (!$family) {
            return $this->alerts(false, 'nullFamily', 'نام خانوادگی وارد نشده است');
        }
        if (!$PersonID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }

        $Person = Person::find($PersonID);
        $Person->fill([
            'name' => $name,
            'family' => $family,
            'phone' => $phone,
            'mobile' => $mobile,
            'net_username' => $net_username,
            'room_number' => $room_number,
            'assistance' => $assistance,
        ]);
        $Person->save();
        $this->logActivity('Person Edited =>' . $PersonID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'personEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getPersonInfo(Request $request)
    {
        $personID = $request->input('id');
        if ($personID) {
            return Person::find($personID);
        }
    }

    public function index()
    {
        $personList = Person::orderBy('personnel_code', 'asc')->paginate(20);
        return \view('PersonManager', ['personList' => $personList]);
    }
}
