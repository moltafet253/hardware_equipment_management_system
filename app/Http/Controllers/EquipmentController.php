<?php

namespace App\Http\Controllers;

use App\Models\EquipmentedCase;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function showEquipmentStatus(Request $request)
    {
        $personId = $request->input('id');
        return view('EquipmentStatus', ['personId' => $personId]);
    }

    public function newCase(Request $request)
    {
        $request->all();
        $personID = $request->input('person');
        $property_number = $request->input('property_number');
        $stamp_number = $request->input('stamp_number');
        $computer_name = $request->input('computer_name');
        $delivery_date = $request->input('delivery_date');
        $caseInfo = $request->input('case');
        $motherboard = $request->input('motherboard');
        $power = $request->input('power');
        $cpu = $request->input('cpu');
        $ram1 = $request->input('ram1');
        $ram2 = $request->input('ram2');
        $ram3 = $request->input('ram3');
        $ram4 = $request->input('ram4');
        $hdd1 = $request->input('hdd1');
        $hdd2 = $request->input('hdd2');
        $graphiccard = $request->input('graphiccard');
        $networkcard = $request->input('networkcard');

        $case = new EquipmentedCase();
        $case->person_id = $personID;
        $case->property_number = $property_number;
        $case->stamp_number = $stamp_number;
        $case->computer_name = $computer_name;
        $case->delivery_date = $delivery_date;
        $case->case = $caseInfo;
        $case->motherboard = $motherboard;
        $case->power = $power;
        $case->cpu = $cpu;
        $case->ram1 = $ram1;
        $case->ram2 = $ram2;
        $case->ram3 = $ram3;
        $case->ram4 = $ram4;
        $case->hdd1 = $hdd1;
        $case->hdd2 = $hdd2;
        $case->graphic_card = $graphiccard;
        $case->network_card = $networkcard;
        $case->save();
    }

}
