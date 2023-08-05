<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Morilog\Jalali\Jalalian;

class DashboardController extends Controller
{
    public function ChangePassword()
    {
        return view('ChangePassword');
    }

    public function ChangePasswordInc(Request $request)
    {
        $oldPass = $request->input('oldPass');
        $newPass = $request->input('newPass');
        $repeatNewPass = $request->input('repeatNewPass');
        $password = User::where('username', session('username'))->value('password');
        if (!$oldPass) {
            return $this->alerts(false, 'oldPassNull', 'رمز عبور فعلی وارد نشده است');
        } elseif (!$newPass) {
            return $this->alerts(false, 'newPassNull', 'رمز عبور جدید وارد نشده است');
        } elseif (strlen($newPass) < 8 and $newPass) {
            return $this->alerts(false, 'lowerThan8', 'رمز عبور جدید کمتر از 8 کاراکتر وارد شده است');
        } elseif (strlen($newPass) > 12 and $newPass) {
            return $this->alerts(false, 'higherThan12', 'رمز عبور جدید بیشتر از 12 کاراکتر وارد شده است');
        } elseif (!$repeatNewPass) {
            return $this->alerts(false, 'repeatNewPassNull', 'تکرار رمز عبور جدید وارد نشده است');
        } elseif ($newPass !== $repeatNewPass) {
            return $this->alerts(false, 'wrongRepeat', 'عدم تطابق رمز عبور جدید و تکرار آن');
        } elseif (!password_verify($oldPass, $password)) {
            return $this->alerts(false, 'wrongPassword', 'رمز عبور فعلی اشتباه است.');
        } else {
            $user = User::where('username', session('username'))->first();
            $user->password = bcrypt($newPass);
            $user->NTCP = 0;
            $user->save();
            $this->logActivity('Password Changed', request()->ip(), request()->userAgent(), session('id'));
            return $this->alerts(true, 'passwordChanged', 'رمز عبور با موفقیت تغییر کرد!');
        }
    }

    public function jalaliDate()
    {
        $data = Jalalian::forge('today')->format('%A, %d %B %Y');
        return $data . ' ' . date("h:i");
    }

    public function index()
    {
        return view('dashboard');
    }
}
