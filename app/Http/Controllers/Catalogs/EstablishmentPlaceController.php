<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\EstablishmentPlace;
use Illuminate\Http\Request;

class EstablishmentPlaceController extends Controller
{
    public function newEstablishmentPlace(Request $request)
    {
        $title = $request->input('title');
        if (!$title) {
            return $this->alerts(false, 'nullName', 'نام محل استقرار وارد نشده است');
        }
        $check = EstablishmentPlace::where('title', $title)->first();
        if ($check) {
            return $this->alerts(false, 'dupName', 'نام محل استقرار تکراری وارد شده است');
        }
        $EstablishmentPlace = new EstablishmentPlace();
        $EstablishmentPlace->title = $title;
        $EstablishmentPlace->save();
        $this->logActivity('Establishment Place Added =>' . $EstablishmentPlace->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'establishmentPlaceAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editEstablishmentPlace(Request $request)
    {
        $editEstablishmentPlaceID = $request->input('editEstablishmentPlace_id');
        $name = $request->input('titleForEdit');
        if (!$name) {
            return $this->alerts(false, 'nullName', 'نام محل استقرار وارد نشده است');
        }
        $check = EstablishmentPlace::where('title', $name)->first();
        if ($check) {
            return $this->alerts(false, 'dupName', 'نام محل استقرار تکراری وارد شده است');
        }

        $EstablishmentPlace = EstablishmentPlace::find($editEstablishmentPlaceID);
        $EstablishmentPlace->fill([
            'title' => $name,
        ]);
        $EstablishmentPlace->save();
        $this->logActivity('Establishment Place Edited =>' . $editEstablishmentPlaceID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'establishmentPlaceEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getEstablishmentPlaceInfo(Request $request)
    {
        $establishmentPlaceID = $request->input('id');
        if ($establishmentPlaceID) {
            return EstablishmentPlace::find($establishmentPlaceID);
        }
    }

    public function index()
    {
        $establishmentPlaceList = EstablishmentPlace::orderBy('title', 'asc')->paginate(20);
        return \view('Catalogs.EstablishmentPlaceCatalog', ['establishmentPlaceList' => $establishmentPlaceList]);
    }
}
