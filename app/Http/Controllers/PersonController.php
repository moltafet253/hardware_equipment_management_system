<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use function Sodium\add;

class PersonController extends Controller
{
    public function newPerson(Request $request)
    {
        $adder = User::find(session('id'));
        $name = $request->input('name');
        $family = $request->input('family');
        $national_code = $request->input('national_code');
        $personnel_code = $request->input('personnel_code');
        $phone = $request->input('phone');
        $mobile = $request->input('mobile');
        $net_username = $request->input('net_username');
        $room_number = $request->input('room_number');
        $assistance = $request->input('assistance');
        $establishment_place = $request->input('establishmentplace');

        if (!$name) {
            return $this->alerts(false, 'nullName', 'نام وارد نشده است');
        }
        if (!$family) {
            return $this->alerts(false, 'nullFamily', 'نام خانوادگی وارد نشده است');
        }
        if (!$assistance) {
            return $this->alerts(false, 'nullAssistance', 'معاونت انتخاب نشده است');
        }
        if (!$personnel_code and !$national_code) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی یا کد ملی وارد نشده است');
        }
        if ($national_code and strlen($national_code) != 10) {
            return $this->alerts(false, 'wrongNationalCode', 'کد ملی صحیح وارد نشده است');
        }

        if ($personnel_code and !$national_code) {
            $check = Person::where('personnel_code', $personnel_code)->first();
            if ($check) {
                return $this->alerts(false, 'dupPersonnelCode', 'کد پرسنلی تکراری وارد شده است');
            }
        }

        $Person = new Person();
        $Person->name = $name;
        $Person->family = $family;
        $Person->national_code = $national_code;
        $Person->personnel_code = $personnel_code;
        $Person->phone = $phone;
        $Person->mobile = $mobile;
        $Person->net_username = $net_username;
        $Person->room_number = $room_number;
        $Person->assistance = $assistance;
        $Person->establishment_place = $establishment_place;
        $Person->work_place = $adder->province_id;
        $Person->adder = session('id');
        $Person->save();
        $this->logActivity('Person Added =>' . $Person->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'PersonAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');

    }

    public function editPerson(Request $request)
    {
        $PersonID = $request->input('personID');
        $name = $request->input('nameForEdit');
        $family = $request->input('familyForEdit');
        $national_code = $request->input('national_codeForEdit');
        $personnel_code = $request->input('personnel_codeForEdit');
        $phone = $request->input('phoneForEdit');
        $mobile = $request->input('mobileForEdit');
        $net_username = $request->input('net_usernameForEdit');
        $room_number = $request->input('room_numberForEdit');
        $assistance = $request->input('assistanceForEdit');
        $establishment_place = $request->input('establishmentplaceForEdit');
        if (!$name) {
            return $this->alerts(false, 'nullName', 'نام وارد نشده است');
        }
        if (!$family) {
            return $this->alerts(false, 'nullFamily', 'نام خانوادگی وارد نشده است');
        }
        if (!$PersonID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$national_code) {
            return $this->alerts(false, 'nullNationalCode', 'کد ملی وارد نشده است');
        }
        if (!$personnel_code) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$assistance) {
            return $this->alerts(false, 'nullAssistance', 'معاونت انتخاب نشده است');
        }

        $Person = Person::find($PersonID);
        $Person->fill([
            'name' => $name,
            'family' => $family,
            'phone' => $phone,
            'national_code' => $national_code,
            'personnel_code' => $personnel_code,
            'mobile' => $mobile,
            'net_username' => $net_username,
            'room_number' => $room_number,
            'assistance' => $assistance,
            'establishment_place' => $establishment_place,
            'editor' => session('id'),
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
        $userInfo = User::find(session('id'));
        $personList = Person::where('work_place', $userInfo->province_id)->orderBy('family', 'asc')->paginate(20);
        return \view('PersonManager', ['personList' => $personList]);
    }
}
