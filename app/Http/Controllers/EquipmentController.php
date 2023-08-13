<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function showEquipmentStatus(Request $request)
    {
        $personId = $request->input('id');
        return view('EquipmentStatus', ['personId' => $personId]);
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


}
